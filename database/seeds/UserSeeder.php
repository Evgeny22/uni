<?php

use Illuminate\Database\Seeder;

use App\User;
use App\School;
use App\Classroom;
use App\Role;
use FileSymfony\Component\Finder\SplFileInfo;



class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::truncate();
        App\Classroom::truncate();
        DB::table('school_user')->truncate();

        // Make one each of the role types
        factory(App\User::class, 'super_admin')->create();
        factory(App\User::class, 'project_admin')->create();
        
        function save_classrooms($filename='', $delimiter=',')
        {
            if(!file_exists($filename) || !is_readable($filename))
                return FALSE;
            $header = NULL;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== FALSE)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
                {
                    if(!$header)
                        $header = $row;
                    else
                        $data = array_combine($header, $row);
                    if(count($data)>0)
                    {
                        $classroom_name = $data['classroom_id'];
                        $school = $data['school'];

                        $school = School::where('name','like',"%$school%")->first();
                        $classroom = Classroom::where('name','like',"$classroom_name")->first();

                        if(strlen($classroom_name)>0 && $classroom == null)
                        {
                            DB::table('classrooms')->insert(['school_id'=>$school->id,'name'=>$classroom_name]);
                        }

                    }
                }
                fclose($handle);
            }
        }
        function save_user($filename='', $delimiter=',')
        {
            if(!file_exists($filename) || !is_readable($filename))
                return FALSE;
            $header = NULL;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== FALSE)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                    if (!$header)
                        $header = $row;
                    else
                        $data = array_combine($header, $row);
                    if (count($data) > 0)
                    {
                        $classroom = $data['classroom_id'];
                        $master_teacher = $data['masterteacher'];
                        $role = $data['role_id'] == 'Master Teacher'
                        || $data['role_id'] == 'School Leader' ? $data['role_id'] :
                            'Teacher';

                        $role = Role::where('display_name', 'like',  $role )->first();
                        $classroom = Classroom::where('name', 'like', $classroom )->first();
                        $master_teacher = User::where('name', 'like', $master_teacher)->first();

                        $data['classroom_id'] = $classroom ? $classroom->id : 0;
                        $data['role_id'] = $role ? $role->id : 0;
                        $data['masterteacher'] = $master_teacher ? $master_teacher->id : 0;
                        $data = array_except($data, 'school');
                        $data['nickname'] = $data['name'];
                        $user = User::where('name','like','%'.$data['name'].'%')->first();
                        if($user == null)
                            DB::table('users')->insert($data);
                    }
                }
                DB::table('users')->update(array('created_at' => DB::raw('CURRENT_TIMESTAMP') , 'updated_at' => DB::raw('CURRENT_TIMESTAMP')));
                fclose($handle);
            }
        }
        function save_schools($filename='', $delimiter=',')
        {
            if(!file_exists($filename) || !is_readable($filename))
                return FALSE;
            $header = NULL;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== FALSE)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
                {
                    if(!$header)
                        $header = $row;
                    else
                        $data = array_combine($header, $row);
                    if(count($data)>0)
                    {
                        $name = $data['name'];
                        $school = $data['school'];

                        $school = School::where('name','like',"%$school%")->first();
                        $user = User::where('name','like',$name)->first();

                        if($user !=null && $school != null)
                        {
                            $user->schools()->save($school);
                        }

                    }
                }
                fclose($handle);
            }
        }

        $subdomain = config("domains.default");
        
        $files = File::allFiles(base_path().'/resources/views/pages/'.$subdomain.'/csv');
        foreach ($files as $csvFile)
        {
            save_classrooms($csvFile);
            save_user($csvFile);
            save_schools($csvFile);
        }
    }

}
