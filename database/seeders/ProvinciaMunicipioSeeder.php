<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaMunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dados = [
            'Bengo' => ['Ambriz', 'Bula Atumba', 'Dande', 'Dembos', 'Nambuangongo', 'Pango Aluquém'],
            'Benguela' => ['Baía Farta', 'Balombo', 'Benguela', 'Bocoio', 'Caimbambo', 'Catumbela', 'Chongoroi', 'Cubal', 'Ganda', 'Lobito'],
            'Bié' => ['Andulo', 'Camacupa', 'Catabola', 'Chinguar', 'Chitembo', 'Cuemba', 'Cunhinga', 'Kuito', 'Nharea'],
            'Cabinda' => ['Belize', 'Buco-Zau', 'Cabinda', 'Cacongo'],
            'Cubango' => ['Calai', 'Cuangar', 'Cuchi', 'Cuito Cuanavale', 'Dirico', 'Mavinga', 'Menongue', 'Rivungo'],
            'Cuanza Norte' => ['Ambaca', 'Banga', 'Bolongongo', 'Cambambe', 'Cazengo', 'Golungo Alto', 'Lucala', 'Quiculungo', 'Samba Cajú'],
            'Cuanza Sul' => ['Amboim', 'Cassongue', 'Conda', 'Ebo', 'Libolo', 'Mussende', 'Porto Amboim', 'Quibala', 'Quilenda', 'Seles', 'Sumbe'],
            'Cunene' => ['Cahama', 'Cuanhama', 'Curoca', 'Cuvelai', 'Namacunde', 'Ombadja'],
            'Huambo' => ['Bailundo', 'Caála', 'Catchiungo', 'Ecunha', 'Huambo', 'Londuimbali', 'Longonjo', 'Mungo', 'Tchicala Tcholoanga', 'Tchindjenje', 'Ucuma'],
            'Huíla' => ['Caconda', 'Cacula', 'Caluquembe', 'Chiange', 'Chibia', 'Chicomba', 'Chipindo', 'Humpata', 'Jamba', 'Lubango', 'Matala', 'Quilengues', 'Quipungo'],
            'Luanda' => ['Belas', 'Cacuaco', 'Cazenga', 'Ícolo e Bengo', 'Luanda', 'Quilamba Quiaxi', 'Talatona', 'Viana'],
            'Lunda Norte' => ['Cambulo', 'Capenda-Camulemba', 'Caungula', 'Chitato', 'Cuango', 'Cuílo', 'Lubalo', 'Lucapa', 'Xá-Muteba'],
            'Lunda Sul' => ['Cacolo', 'Dala', 'Muconda', 'Saurimo'],
            'Malanje' => ['Cacuso', 'Calandula', 'Cambundi-Catembo', 'Cangandala', 'Caombo', 'Cuaba Nzogo', 'Cuemba', 'Luquembo', 'Malanje', 'Marimba', 'Massango', 'Mucari', 'Quela', 'Quirima'],
            'Moxico' => ['Alto Zambeze', 'Bundas', 'Camanongue', 'Cameia', 'Léua', 'Luacano', 'Luau', 'Luchazes', 'Moxico'],
            'Namibe' => ['Bibala', 'Camucuio', 'Moçâmedes', 'Tômbua', 'Virei'],
            'Uíge' => ['Alto Cauale', 'Ambuíla', 'Bembe', 'Buengas', 'Bungo', 'Damba', 'Kimbele', 'Maquela do Zombo', 'Mucaba', 'Negage', 'Puri', 'Quimbele', 'Quitexe', 'Sanza Pombo', 'Songo', 'Uíge', 'Zombo'],
            'Zaire' => ['Cuimba', 'Mbanza Kongo', 'Nóqui', 'Nzeto', 'Soyo', 'Tomboco'],
            'Icolo e Bengo' => ['Catete', 'Bom Jesus', 'Cabiri', 'Calomboloca', 'Kakulo-Kahango', 'Kassoneca'],
            'Moxico Leste' => ['Lumbala Nguimbo', 'Luvuei', 'Sessa', 'Cangombe', 'Muie'],
            'Cuando' => ['Menongue', 'Cuito Cuanavale', 'Cuchi', 'Calai', 'Cuangar', 'Dirico', 'Mavinga', 'Rivungo']
        ];

        foreach ($dados as $provincia => $municipios) {
            // Verifica se a provincia já existe
            $provinciaExistente = DB::table('provincias')->where('provincia', $provincia)->first();

            if ($provinciaExistente) {
                $provinciaId = $provinciaExistente->id;
            } else {
                $provinciaId = DB::table('provincias')->insertGetId([
                    'provincia' => $provincia,
                    'sigla' => strtoupper($provincia),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($municipios as $municipio) {
                // Verifica se o municipio já existe
                $municipioExistente = DB::table('municipios')->where('municipio', $municipio)
                    ->where('provincias_id', $provinciaId)->first();

                if (!$municipioExistente) {
                    DB::table('municipios')->insert([
                        'provincias_id' => $provinciaId,
                        'municipio' => $municipio,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
