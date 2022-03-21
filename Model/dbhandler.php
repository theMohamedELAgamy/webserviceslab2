<?php
use Illuminate\Database\Capsule\Manager as Capsule;
class dbhandler{
    
      static function returncapsule(){
           return $table=Capsule::table("items");
      }
    
    static function connect(){
            
           $capsule = new Capsule();
            $capsule->addConnection([
                "driver" => _driver_,
                "host" => _host_,
                "database" => _database_,
                "username" => _username_,
                "password" => _password_
            ]);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
    }
    static function get_data($index){
        $all_requrds= Capsule::table("items")->skip($index)->take(_Pager_size_)->get();
                    echo "<table border='1'>";
                $record_index = 0;
            foreach ($all_requrds as $item) {
                if ($record_index === 0) {
                    echo "<tr>";
                    echo "<td> Name </td>";
                    echo "<td> Price </td>";
                    echo "<td> Country </td>";
                     echo "<td> photo </td>";
                      echo "<td> view </td>";

                    echo "</tr>";
                }
                echo "<tr>";

                    echo "<td>".$item->product_name ."</td>";
                    echo "<td>".$item->list_price ."</td>";
                    echo "<td>".$item->CouNtry ."</td>";
                    
                     $imag=explode(".",$item->Photo);
                     $imag=$imag[0]."tz.".$imag[1];
                     $imag="images/$imag";
                    echo "<td><img src=$imag></td>";
                    $more="more.php?id=$item->id";
                    echo "<td><a href=$more> more</a> </td>";
                echo "</tr>";

                $record_index ++;
            }
            echo "</table>";        
    }
    static function get_record($id) {
        
        return $record= Capsule::table("items")->find(number_format($id));
        //      echo "<center>";     
        // echo "<table border='1'>";
                
            
        //             echo "<tr>";
        //             echo "<td> Name </td>";
        //             echo "<td> Price </td>";
        //             echo "<td> Country </td>";

        //             echo "</tr>";
                
        //         echo "<tr>";

        //             echo "<td>".$record->product_name ."</td>";
        //             echo "<td>".$record->list_price ."</td>";
        //             echo "<td>".$record->CouNtry ."</td>";
                    
        //         echo "</tr>";
        //         echo "</center>"; 
                
    }
    static function get_table($table){
        return $record= Capsule::table($table)->get();
    }

}
