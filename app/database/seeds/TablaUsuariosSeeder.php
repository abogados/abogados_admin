<?php
class TablaUsuariosSeeder extends Seeder {
 
    public function run()
    {
        $usuario = [
            ['nombre' => 'admin',
            'apellido' => '',
            'user' => 'admin', 
            'password' => Hash::make('admin123'), 
            'email' => 'estudio.aboga2@gmail.com',
            'perfil' => 'Administrador',
            'dni' => '11111111',
            'estado' => 'Activo']
        ];
 
        DB::table('usuarios')->insert($usuario);
    }
 
}
