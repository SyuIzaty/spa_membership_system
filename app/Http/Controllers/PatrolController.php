<?php

namespace App\Http\Controllers;

use App\Patrol;
use Illuminate\Http\Request;
use DB;

class PatrolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data = Patrol::WHERE('SM_STATUS','AKTIF')->first();
        //$err = '';
        // $data = DB::connection('oracle')->select(
        //    DB::raw("SET NOCOUNT ON  exec CMS.validateUser('yuzi','284279')")
        // );

        //$data = DB::connection('oracle')->select('SET NOCOUNT ON exec CMS.validateUser(?, ?, ?)', array('yuzi', 'Luis Arce', null));

        // $data = 'yuzi';

        // $pdo = DB::connection('oracle')->getPdo();

        //  $p1 = 'yuzi';
        //  $p2 = 'eheh';
        // $stmt = $pdo->prepare("begin CMS.validateUser(:username, :passwd, :errmsg); end;");

        //  $stmt->bindParam(':username', $p1);   //<---------------
        //  $stmt->bindParam(':passwd', $p2);
        //  $stmt->bindParam(':errmsg', $p3, \PDO::PARAM_STR_CHAR);
        //  $stmt->execute();
        //  dd($p3);

        // DB::connection('oracle')->statement('CALL CMS.validateUser(:username, :passwd, @errmsg)',
        //         array(
        //             'yuzi',
        //             '284279',
        //             ''
        //         )
        //     );

        //     $data =  DB::select('select @errmsg as err');
        //     dd($data);



        //$data = DB::connection('oracle')->select("EXEC CMS.validateUser($username,$passwd,$err),array ('username' => 'YUZI','passwd' => '284279', 'err' => 'OK')");

        //$data  = DB::connection('oracle')->select(DB::raw("exec CMS.validateUser(val1)"), array ('val1' => 'yuzi','val2' => '284279',' val3' = 'OK'));

        //$data = DB::connection('oracle')->select('SET NOCOUNT ON exec CMS.validateUsser ?, ?, ?', array('yuzi', '284279', ''));

    //    $result = DB::connection('oracle')->execute('CMS.validateUsser(:username,:passwd,:errmsg)', [':username' => 'yuzi', ':passwd' => '284279', ':errmsg' => ''], \PDO::PARAM_STR);

    $fbck = '';
    $data = DB::connection('oracle')->executeFunction('CMS.validateUser(:binding_1,:binding_2,:fbck)', [':username' => 'yuzi', ':passwd' => '1234','@errmsg' => $fbck], \PDO::PARAM_LOB);


    dd($fbck);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('log_input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function show(Patrol $patrol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function edit(Patrol $patrol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patrol $patrol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patrol  $patrol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patrol $patrol)
    {
        //
    }
}
