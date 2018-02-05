<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffees', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('titlu');
            $table->string('tara');
            $table->string('poza')->nullable();
            $table->string('descriere');
        });
        
        Schema::create('coffees_updated', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titlu');
            $table->string('status');
            $table->timestamps();
        });
        
        DB::unprepared("CREATE PROCEDURE InsertCoffees(IN var_titlu varchar(255),IN var_tara varchar(255),IN var_poza varchar(255),IN var_descriere varchar(225))
                BEGIN
                INSERT INTO coffees(titlu,tara,poza,descriere)VALUES(var_titlu,var_tara,var_poza,var_descriere);
                END;");
        
        DB::unprepared('CREATE TRIGGER BITrigger BEFORE INSERT ON coffees FOR EACH ROW
                BEGIN
                SET NEW.titlu=UPPER(NEW.titlu);
                END');
        
        DB::unprepared('CREATE TRIGGER AUTrigger AFTER UPDATE ON coffees FOR EACH ROW
                BEGIN
                INSERT INTO coffees_updated(titlu,status)VALUES(NEW.titlu,"UPDATED");
                END');
        
        DB::unprepared("CREATE PROCEDURE UpdateCoffees(IN var_titlu varchar(255),IN var_tara varchar(255),IN var_poza varchar(255),IN var_descriere varchar(225), IN var_id int)
                 BEGIN
                 UPDATE coffees SET titlu=var_titlu, tara=var_tara, poza=var_poza, descriere=var_descriere where id=var_id;
                 END");
        
        DB::unprepared('CREATE PROCEDURE GetUpdate()
                BEGIN SELECT * FROM coffees_updated; 
                END');
         
        DB::unprepared('CREATE PROCEDURE GetCoffees()
                BEGIN
                SELECT * FROM coffees;
                END');
        
        DB::unprepared('CREATE PROCEDURE GetCoffee(IN var_titlu varchar(255))
                BEGIN
                SELECT * FROM coffees WHERE titlu=var_titlu;
                END');
        
        DB::unprepared("CREATE PROCEDURE DeleteCoffees(IN var_id int)
                BEGIN
                DELETE FROM coffees where id=var_id;
                END");
        
        DB::unprepared('CREATE TRIGGER AfterDelete AFTER DELETE ON coffees FOR EACH ROW
                BEGIN
                INSERT INTO coffees_updated(titlu, status) VALUES(OLD.titlu,"DELETED");
                END;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coffees');
        Schema::dropIfExists('coffees_updated');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCoffees');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCoffee');
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertCoffees');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteCoffees');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetUpdate');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateCoffees');
        DB::unprepared('DROP TRIGGER IF EXISTS BITrigger');
        DB::unprepared('DROP TRIGGER IF EXISTS AUTrigger');
        DB::unprepared('DROP TRIGGER IF EXISTS AfterDelete');
    }
}
