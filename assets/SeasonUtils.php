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
            //print_r($r,true);
            $a = new \app\assets\Ergast;
            $curr = $a->callErgast($r['year']."/".$r['round']."/results.json");
            //$curr = $a->callErgast("2018/15/results.json");
            $jdata = \json_decode($curr);
            $race = $jdata->MRData->RaceTable;
            if(empty($race->Races)){
                die (\Yii::t('app','Nothing to do'));
            }
            //echo print_r($race,true);
            //process the results
            foreach( $race->Races[0]->Results as $res ){
                //get DB driver ID
                $dbDriver = \app\models\Drivers::find()->where(['driverRef'=>$res->Driver->driverId])->one();
                //get DB constructor ID 
                $dbConstructor = \app\models\Constructors::find()->where(['constructorRef'=>$res->Constructor->constructorId])->one();
                // #### WE HAVE TO UPDATE RESULTS BEFORE EVERYTHING ELSE!!!
                // #### STANDINGS CHANGE FROM RACE TO RACE
                //update results
                
                // //get DB wins for the driver
                // $dbdWins = \app\models\Driverstandings::find()
                // ->join('INNER JOIN', 'races', 'driverstandings.raceId = races.raceId')
                // ->where(['driverId'=>$dbDriver['driverId']])
                // ->andWhere(['races.year'=>$r['year']])
                // ->orderBy('driverstandings.raceId DESC')
                // ->one();
                
                // //get DB wins for constructor
                // $dbcWins = \app\models\Constructorstandings::find()
                // ->join('INNER JOIN', 'races', 'constructorstandings.raceId = races.raceId')
                // ->where(['constructorId'=>$dbConstructor['constructorId']])
                // ->andWhere(['races.year'=>2018])
                // // ->andWhere(['races.year'=>$r['year']])
                // ->orderBy('constructorstandings.raceId DESC')
                // ->one();
                // var_dump($dbcWins);

                // //update diverstandings
                // $ds = new \app\models\Driverstandings();
                // $ds->raceId = $dbRaceID;
                // $ds->driverId = $dbDriver['driverId'];
                // $ds->points = (int)$res->points + (int)$dbdWins['points'];
                // $ds->position = $res->position;
                // $ds->positionText = $res->positionText;
                // $ds->wins = ($res->position==1) ? (int)$dbdWins['wins'] + 1 : (int)$dbdWins['wins'];
                // // if(!$ds->save()){
                // //     echo "###### ERROR ###### -> can't update standings for Driver:  ".$r->Driver->driverId;
                // // }
                // //update constructorstandings
                // $cs = new \app\models\Constructorstandings();
                // $cs->raceId = $dbRaceID;
                // $cs->constructorId = $dbConstructor['constructorId'];
                // $cs->points = (int)$res->points + (int)$dbcWins['points'];
                

                //echo print_r($res,true);
            }
            echo "</pre>";
        }
        //look for results on ergast and insert in DB
        // $curr = file_get_contents("https://ergast.com/api/f1/2019/1/results.json");
        //echo "<pre>".print_r($curr,true)."</pre>";
    }
}