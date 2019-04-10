<?php

namespace app\assets;

class SeasonUtils{
    public static function getNextGp($year='', $now=''){
        if($now==''){
            $now = date("Y-m-d");
        }
        if($year==''){
            $year = date("Y");
        }
        //search for the next race on database
        $rac = \app\models\Races::find()
        ->where( ['year'=>$year] )
        ->andWhere( ['>','date',$now] )
        ->one();
        //return var_dump($rac->raceId);
        if( isset($rac->raceId) ){
            return $rac;
        }
        //search for the race on ergast
        $rac = file_get_contents("http://ergast.com/api/f1/".$year."/next.json");
        return $rac;
    }
    public static function getRaceTimezone($raceid){
        if(!$raceid||$raceid==''){
            return false;
        }
        $rows = (new \yii\db\Query())
        ->select(['z.zone_name'])
        ->from('races r')
        ->innerJoin('circuits c', 'c.circuitId = r.circuitId')
        ->innerJoin('country co', 'c.country = co.country_name')
        ->innerJoin('zone z', 'co.country_code = z.country_code')
        ->where(['r.raceId' => $raceid])
        ->one();
        // print_r($rows);exit;
        return $rows['zone_name'];
    }
    public static function alignLastResult(){
        //find all the races without result
        $rac = \app\models\Races::find()
        ->leftJoin('results', 'races.raceId = results.raceId')
        ->where(['results.raceId' => null])
        ->andWhere( ['<', 'races.date', new \yii\db\Expression('NOW()')] )
        ->orderBy('races.date ASC')
        ->all()
        ;
        foreach($rac  as $r){
            $dbRaceID = $r['raceId'];
            echo "<pre>";
            echo "---------------------------------------------------\n";
            echo "RACEID: $dbRaceID BEGIN \n ";
            echo "---------------------------------------------------\n";

            //results routine
            
            $a = new \app\assets\Ergast;
            $curr = $a->callErgast($r['year']."/".$r['round']."/results.json");
            $jdata = \json_decode($curr);
            $race = $jdata->MRData->RaceTable;
            if(empty($race->Races)){
                echo \Yii::t('app','No result to update');
                continue;
            }
            //echo print_r($race,true);
            //process the results
            foreach( $race->Races[0]->Results as $res ){
                //get DB driver ID
                $dbDriver = \app\models\Drivers::find()->where(['driverRef'=>$res->Driver->driverId])->one();
                //get DB constructor ID 
                $dbConstructor = \app\models\Constructors::find()->where(['constructorRef'=>$res->Constructor->constructorId])->one();
                //get DB result ID
                $dbStatus = \app\models\Status::find()->where(['status'=>$res->status])->one();
                // var_dump($dbStatus);
                //echo "d: ".$res->Driver->driverId." - ID: ".$dbDriver['driverId']." - status: ".$res->status." - statusID: ".$dbStatus['statusId']."\n";
                
                //update constructor result
                $dbConResult = \app\models\Constructorresults::find()->where(['raceId'=>$dbRaceID, 'constructorId'=>$dbConstructor['constructorId']])->one();
                // var_dump($dbConResult);
                if($dbConResult){
                    $dbConResult['points'] = $dbConResult['points'] + $res->points;
                    if(!$dbConResult->save()){
                        echo "ERROR: update constructorresult. ConstructorID: ".$dbConstructor['constructorId'].". RaceID: $dbRaceID\n";
                    }
                    else{
                        echo "SUCCESS: constructorresult updated. ConstructorID: ".$dbConstructor['constructorId'].". RaceID: $dbRaceID\n";
                    }
                }
                else{
                    $db = new \app\models\Constructorresults();
                    $db->raceId = $dbRaceID;
                    $db->constructorId = $dbConstructor['constructorId'];
                    $db->points = $res->points;
                    $db->status = '';
                    if(!$db->save()){
                        echo "ERROR: save constructorresult. ConstructorID: ".$dbConstructor['constructorId'].". RaceID: $dbRaceID\n";
                    }
                    else{
                        echo "SUCCESS: constructorresult inserted. ConstructorID: ".$dbConstructor['constructorId'].". RaceID: $dbRaceID\n";
                    }
                }

                //update driver results
                $dbResult = new \app\models\Results();
                $dbResult->raceId = $dbRaceID;
                $dbResult->driverId = $dbDriver['driverId'];
                $dbResult->constructorId = $dbConstructor['constructorId'];
                $dbResult->number = $res->number;
                $dbResult->grid = $res->grid;
                $dbResult->position = $res->position;
                $dbResult->positionText = $res->positionText;
                $dbResult->positionOrder = $res->position;
                $dbResult->points = $res->points;
                $dbResult->laps = $res->laps;
                $dbResult->time = (isset($res->Time->time) ? $res->Time->time : '');
                $dbResult->milliseconds = (isset($res->Time->millis) ? $res->Time->millis : '');
                $dbResult->fastestLap = (isset($res->FastestLap->lap) ? $res->FastestLap->lap : '');
                $dbResult->rank = (isset($res->FastestLap->rank) ? $res->FastestLap->rank : '');
                $dbResult->fastestLapSpeed = (isset($res->FastestLap->AverageSpeed->speed) ? $res->FastestLap->AverageSpeed->speed : ''); 
                $dbResult->fastestLapTime = (isset($res->FastestLap->Time->time) ? $res->FastestLap->Time->time : '');
                $dbResult->statusId = $dbStatus['statusId'];
                if(!$dbResult->save()){
                    echo "ERROR: Impossible to save data for driverresult. DriverID: ".$dbDriver['driverId']." RaceID: $dbRaceID\n";
                }
                else{
                    echo "SUCCESS: Driver result . DriverID: ".$dbDriver['driverId']." RaceID: $dbRaceID\n";
                }
            }

            //drivers standings routine
            $curr = $a->callErgast($r['year']."/".$r['round']."/driverStandings.json");
            $jdata = \json_decode($curr);
            $stands = $jdata->MRData->StandingsTable;
            if(empty($stands->StandingsLists)){
                echo \Yii::t('app','No driver standing to update');
                continue;
            }
            foreach( $stands->StandingsLists[0]->DriverStandings as $res ){
                //get DB driver ID
                $dbDriver = \app\models\Drivers::find()->where(['driverRef'=>$res->Driver->driverId])->one();
                $db = new \app\models\Driverstandings();
                $db->raceId = $dbRaceID;
                $db->driverId = $dbDriver['driverId'];
                $db->points = $res->points;
                $db->position = $res->position;
                $db->positionText = $res->positionText;
                $db->wins = $res->wins;
                if(!$db->save()){
                    echo "ERROR on save driverstandings. driverID: ".$dbDriver['driverId'].". RaceID: $dbRaceID\n";
                }
                else{
                    echo "SUCCESS: driverstandings. driverID: ".$dbDriver['driverId'].". RaceID: $dbRaceID\n";
                }
            }
            
            //constructor standings routine
            $curr = $a->callErgast($r['year']."/".$r['round']."/constructorStandings.json");
            $jdata = \json_decode($curr);
            $stands = $jdata->MRData->StandingsTable;
            if(empty($stands->StandingsLists)){
                echo \Yii::t('app','No constructor standing to update');
                continue;
            }
            foreach( $stands->StandingsLists[0]->ConstructorStandings as $res ){
                //get DB constructor ID 
                $dbConstructor = \app\models\Constructors::find()->where(['constructorRef'=>$res->Constructor->constructorId])->one();
                $db = new \app\models\Constructorstandings();
                $db->raceId = $dbRaceID;
                $db->constructorId = $dbConstructor['constructorId'];
                $db->points = $res->points;
                $db->position = $res->position;
                $db->positionText = $res->positionText;
                $db->wins = $res->wins;
                if(!$db->save()){
                    echo "ERROR on save constructorstandings. constructorID: ".$dbConstructor['constructorId'].". RaceID: $dbRaceID\n";
                }
                else{
                    echo "SUCCESS: constructorstandings. constructorID: ".$dbConstructor['constructorId'].". RaceID: $dbRaceID\n";
                }
            }
            echo "RACEID: $dbRaceID END \n ";
            echo "---------------------------------------------------\n";
            echo "</pre>";
        }
        echo '<br><br><br><a href="/index.php">Back to Home</a>';
    }
}