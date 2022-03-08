<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AgentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->insert([
            [
                'name' => 'Ariadna Toquero - Optima Retail (EQ7)',
                'email' => 'ariadna.toquero@optimaretail.es'
            ], [
                'name' => 'Francisco Luna - Optima Retail (EQ7)',
                'email' => 'francisco.luna@optimaretail.es'
            ], [
                'name' => 'Josep Crespo - Optima Retail (EQ9)',
                'email' => 'josep.crespo@optimaretail.es'
            ], [
                'name' => 'Ana Blasco - Optima Retail (EQ2)',
                'email' => 'ana.blasco@optimaretail.es'
            ], [
                'name' => 'Laura Guillen - Optima Retail (EQ2)',
                'email' => 'laura.guillen@optimaretail.es'
            ], [
                'name' => 'Sonia Risquez - Optima Retail (ADM)',
                'email' => 'sonia.risquez@optimaretail.es'
            ], [
                'name' => 'Suleiman Daimoussi - Optima Retail (EQ4)',
                'email' => 'suleiman.daimoussi@optimaretail.es'
            ], [
                'name' => 'Alex Garriga - Optima Retail (EQ1)',
                'email' => 'alex.garriga@optimaretail.es'
            ], [
                'name' => 'Eduardo Conde - Optima Retail (EQ7)',
                'email' => 'eduardo.conde@optimaretail.es'
            ], [
                'name' => 'Bruno Riva - Optima Retail (EQ5)',
                'email' => 'bruno.riva@optimaretail.es'
            ], [
                'name' => 'Daniel Molina - Optima Retail (TI)',
                'email' => 'daniel.molina@optimaretail.es'
            ], [
                'name' => 'Judit Neira - Optima Retail (EQ1)',
                'email' => 'judit.neira@optimaretail.es'
            ], [
                'name' => 'Susana Vazquez - Optima Retail ',
                'email' => 'susana.vazquez@optimaretail.es'
            ], [
                'name' => 'Diana Ginter -Optima Retail (EQ8)',
                'email' => 'diana.ginter@optimaretail.es'
            ], [
                'name' => 'Rosa Ruiz - Optima Retail ',
                'email' => 'rosa.ruiz@optimaretail.es'
            ], [
                'name' => 'Alba Male - Optima Retail (EQ6)',
                'email' => 'alba.male@optimaretail.es'
            ], [
                'name' => 'Edgar Abillá - Optima Retail (EQ9)',
                'email' => 'edgar.abilla@optimaretail.es'
            ], [
                'name' => 'Laia Navarro - Optima Retail (EQ9)',
                'email' => 'laia.navarro@optimaretail.es'
            ], [
                'name' => 'Alberto Lahoz - Optima Retail (EQ3)',
                'email' => 'alberto.lahoz@optimaretail.es'
            ], [
                'name' => 'Mireia Navarro - Optima Retail (TEQ)',
                'email' => 'mireia.navarro@optimaretail.es'
            ], [
                'name' => 'Ainoa Sebastián - Optima Retail (EQ3)',
                'email' => 'ainoa.sebastian@optimaretail.es'
            ], [
                'name' => 'Georgina Puyo - Optima Retail (EQ9)',
                'email' => 'georgina.puyo@optimaretail.es'
            ], [
                'name' => 'Cristina Moruno - Optima Retail (EQ7)',
                'email' => 'cristina.moruno@optimaretail.es'
            ], [
                'name' => 'Patricia Gil - Optima Retail ',
                'email' => 'patricia.gil@optimaretail.es'
            ], [
                'name' => 'Alberto Castillo - Optima Retail (EQ9)',
                'email' => 'alberto.castillo@optimaretail.es'
            ], [
                'name' => 'Roman Cabrero - Optima Retail (EQ7)',
                'email' => 'roman.cabrero@optimaretail.es'
            ], [
                'name' => 'Marta Sanz - Optima Retail (EQ1)',
                'email' => 'marta.sanz@optimaretail.es'
            ], [
                'name' => 'Carla Perez - Optima Retail (ADM)',
                'email' => 'carla.perez@optimaretail.es'
            ], [
                'name' => 'Ivan Navarro - Optima Retail (TEQ)',
                'email' => 'ivan.navarro@optimaretail.es'
            ],[
                'name' => 'Bea Dovon - Optima Retail',
                'email' => 'bea.dovon@optimaretail.es'
            ], [
                'name' => 'Rosina Motilla - Optima Retail (EQ4)',
                'email' => 'rosina.motilla@optimaretail.es'
            ], [
                'name' => 'Nico Duval - Optima Retail (EQ4)',
                'email' => 'nico.duval@optimaretail.es'
            ], [
                'name' => 'Raúl Medina - Optima Retail (EQ3)',
                'email' => 'raul.medina@optimaretail.es'
            ], [
                'name' => 'Jean Pierre - Optima Retail (EQ4)',
                'email' => 'jeanpierre.pugliese@optimaretail.es'
            ], [
                'name' => 'Berta Vilamala - Optima Retail (EQ6)',
                'email' => 'berta.vilamala@optimaretail.es'
            ], [
                'name' => 'Sara Algaba - Optima Retail (EQ3)',
                'email' => 'sara.algaba@optimaretail.es'
            ], [
                'name' => 'Omar Laurencena -Optima Retail (GUA)',
                'email' => 'omar.laurencena@optimaretail.es'
            ], [
                'name' => 'Ivan Rubio - Optima Retail (QC)',
                'email' => 'ivan.rubio@optimaretail.es'
            ], [
                'name' => 'Miguel Lomanto - Optima Retail (EQ1)',
                'email' => 'miguel.lomanto@optimaretail.es'
            ], [
                'name' => 'Sandra Gonzalez -Optima Retail (EQ4)',
                'email' => 'sandra.gonzalez@optimaretail.es'
            ], [
                'name' => 'Fran Ullod - Optima Retail ',
                'email' => 'fran.ullod@optimaretail.es'
            ], [
                'name' => 'Anna Oliva - Optima Retail (EQ8)',
                'email' => 'anna.oliva@optimaretail.es'
            ], [
                'name' => 'Irene Fernández - Optima Retail (EQ7)',
                'email' => 'irene.fernandez@optimaretail.es'
            ], [
                'name' => 'Victor Ballester - Optima Retail (EQ5)',
                'email' => 'victor.ballester@optimaretail.es'
            ], [
                'name' => 'Noelia Gomez - Optima Retail (EQ3)',
                'email' => 'noelia.gomez@optimaretail.es'
            ], [
                'name' => 'Marta Dube - Optima Retail (EQ4)',
                'email' => 'marta.dube@optimaretail.es'
            ], [
                'name' => 'Zoraida Aragonés - Optima Retail (EQ1)',
                'email' => 'zoraida.aragones@optimaretail.es'
            ], [
                'name' => 'Javier Jimenez - Optima Retail (EQ7)',
                'email' => 'javier.jimenez@optimaretail.es'
            ]
        ]);
    }
}
