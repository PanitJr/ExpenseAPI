<?php

use App\Object\Users\Users;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\ParameterBag;

class CreateUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use WithoutMiddleware;
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        \Illuminate\Support\Facades\Auth::loginUsingId(9);
        $testUser = new Users();
        $testUser->user_name = 'panit';
        $testUser->email = 'test@testtest.com';
        $testUser->role_id = 4;
        $testUser->supervisor_id = 9;
        $testUser->remember_token = 'Token';
        $testUser->save();
        $this->User = $testUser;
    }

    public function testGetInstanceEditUser()
    {
        $this->get('api/Users/edit/')
            ->seeJson([
                'success' => True,

            ])->seeJsonStructure([
                'success',
                'data'=> [
                    'data',
                    'blocks'
                ]
            ]);
    }
    public function testGetEditUser(){
        $this->get('api/Users/edit/'.$this->User['id'])
            ->seeJson([
                'success' => True
            ])->seeJsonStructure([
                'success',
                'data'=> [
                    'data',
                    'blocks'
                ]
            ]);
    }
    public function testCCEditUser(){
        $ccEdit = new \App\Object\Users\CCEdit();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->andReturn('Users/edit/'.$this->User['id']);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->request = new ParameterBag([   'user_name' => 'panit',
                'email'=>'test@testtest.com',
                'role_id'=>4,
                'supervisor_id'=>9,
                'remember_token'=>'Token'
            ]);
        $request->setRouteResolver(function () use ($request) {
            return (new Route('GET', '{objectName}/edit/{record?}', []))->bind($request);
        });
        $block = [
            [
                "id"=> 5,
                "objectid"=> 5,
                "blocklabel"=> "User Manager",
                "sequence"=> 1,
                "fields"=> [
                    [
                        "id"=> 11,
                        "objectid"=> 5,
                        "fieldname"=> "user_name",
                        "fieldlabel"=> "Username",
                        "sequence"=> 1,
                        "blockid"=> 5,
                        "type"=> [
                            "id"=> 4,
                            "fieldtype"=> "text"
                        ]
                    ],
                    [
                        "id"=> 10,
                        "objectid"=> 5,
                        "fieldname"=> "email",
                        "fieldlabel"=> "Email",
                        "sequence"=> 2,
                        "blockid"=> 5,
                        "type"=> [
                            "id"=> 4,
                            "fieldtype"=> "text"
                        ]
                    ],
                    [
                        "id"=> 12,
                        "objectid"=> 5,
                        "fieldname"=> "firstname",
                        "fieldlabel"=> "First Name",
                        "sequence"=> 5,
                        "blockid"=> 5,
                        "type"=> [
                            "id"=> 4,
                            "fieldtype"=> "text"
                        ]
                    ],
                    [
                        "id"=> 13,
                        "objectid"=> 5,
                        "fieldname"=> "lastname",
                        "fieldlabel"=> "Last Name",
                        "sequence"=> 6,
                        "blockid"=> 5,
                        "type"=> [
                            "id"=> 4,
                            "fieldtype"=> "text"
                        ]
                    ],
                    [
                        "id"=> 21,
                        "objectid"=> 5,
                        "fieldname"=> "role_id",
                        "fieldlabel"=> "Role",
                        "sequence"=> 7,
                        "blockid"=> 5,
                        "type"=> [
                            "id"=> 5,
                            "fieldtype"=> "picklist"
                        ],
                        "Role"=> [
                            [
                                "id"=> 4,
                                "name"=> "Admin",
                                "role_description"=> "System Admininstator",
                                "parent_role"=> 4
                            ],
                            [
                                "id"=> 5,
                                "name"=> "Supervisor",
                                "role_description"=> "Supervisor is a head of department",
                                "parent_role"=> 4
                            ],
                            [
                                "id"=> 19,
                                "name"=> "Employees",
                                "role_description"=> "Employees of company",
                                "parent_role"=> 5
                            ]
                        ],
                        "Profile"=> [
                            [
                                "id"=> 2,
                                "profilename"=> "Admin",
                                "description"=> "Admin"
                            ],
                            [
                                "id"=> 3,
                                "profilename"=> "Supervisor",
                                "description"=> "Supervisor\n"
                            ],
                            [
                                "id"=> 20,
                                "profilename"=> "Emmployee",
                                "description"=> "Emmployee"
                            ]
                        ]
                    ],
                    [
                        "id"=> 25,
                        "objectid"=> 5,
                        "fieldname"=> "supervisor_id",
                        "fieldlabel"=> "supervisor",
                        "sequence"=> 8,
                        "blockid"=> 5,
                        "type"=> [
                            "id"=> 5,
                            "fieldtype"=> "picklist"
                        ],
                        "supervisor"=> [
                            [
                                "id"=> 1,
                                "user_name"=> "erp",
                                "email"=> "erp@mail.com",
                                "created_at"=> null,
                                "updated_at"=> "2016-12-16 20=>04=>46",
                                "firstname"=> "ERPS",
                                "lastname"=> "DEMO",
                                "admin"=> 0,
                                "role_id"=> 4,
                                "supervisor_id"=> 1,
                                "status"=> 1
                            ],
                            [
                                "id"=> 9,
                                "user_name"=> "panit@crm-c.club",
                                "email"=> "panit@crm-c.club",
                                "created_at"=> null,
                                "updated_at"=> "2016-12-24 14=>25=>25",
                                "firstname"=> "Panit",
                                "lastname"=> "Jaijaroen",
                                "admin"=> 0,
                                "role_id"=> 4,
                                "supervisor_id"=> 1,
                                "status"=> 2
                            ],
                            [
                                "id"=> 14,
                                "user_name"=> "waitingforthen@gmail.com",
                                "email"=> "waitingforthen@gmail.com",
                                "created_at"=> null,
                                "updated_at"=> "2017-01-10 12=>05=>48",
                                "firstname"=> "พณิช",
                                "lastname"=> "ใจเจริญ",
                                "admin"=> 0,
                                "role_id"=> 5,
                                "supervisor_id"=> 9,
                                "status"=> 0
                            ],
                            [
                                "id"=> 15,
                                "user_name"=> "chanakan@crm-c.club",
                                "email"=> "chanakan@crm-c.club",
                                "created_at"=> null,
                                "updated_at"=> null,
                                "firstname"=> "Pai",
                                "lastname"=> "PaiPai",
                                "admin"=> 0,
                                "role_id"=> 19,
                                "supervisor_id"=> 9,
                                "status"=> 1
                            ],
                            [
                                "id"=> 16,
                                "user_name"=> "June",
                                "email"=> "viparat@crm-c.club",
                                "created_at"=> null,
                                "updated_at"=> null,
                                "firstname"=> "",
                                "lastname"=> "",
                                "admin"=> 0,
                                "role_id"=> 19,
                                "supervisor_id"=> 14,
                                "status"=> 0
                            ],
                            [
                                "id"=> 23,
                                "user_name"=> "test@crm-c.club",
                                "email"=> "test@crm-c.club",
                                "created_at"=> null,
                                "updated_at"=> null,
                                "firstname"=> "test",
                                "lastname"=> "test",
                                "admin"=> 0,
                                "role_id"=> 19,
                                "supervisor_id"=> 0,
                                "status"=> 1
                            ],
                            [
                                "id"=> 33,
                                "user_name"=> "asca",
                                "email"=> "asd@asdcasc.com",
                                "created_at"=> null,
                                "updated_at"=> null,
                                "firstname"=> "acsac",
                                "lastname"=> "",
                                "admin"=> 0,
                                "role_id"=> 19,
                                "supervisor_id"=> 9,
                                "status"=> 1
                            ],
                            [
                                "id"=> 34,
                                "user_name"=> "vdfb",
                                "email"=> "agd@adv.com",
                                "created_at"=> null,
                                "updated_at"=> null,
                                "firstname"=> "",
                                "lastname"=> "",
                                "admin"=> 0,
                                "role_id"=> 19,
                                "supervisor_id"=> 1,
                                "status"=> 1
                            ]
                        ]
                    ],
                    [
                        "id"=> 53,
                        "objectid"=> 5,
                        "fieldname"=> "status",
                        "fieldlabel"=> "status",
                        "sequence"=> 9,
                        "blockid"=> 5,
                        "type"=> [
                            "id"=> 5,
                            "fieldtype"=> "picklist"
                        ],
                        "status"=> [
                            [
                                "id"=> 1,
                                "name"=> "active"
                            ],
                            [
                                "id"=> 2,
                                "name"=> "inactive"
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals(true,$ccEdit->checkPermission($request));
        $this->assertNotEquals($ccEdit->convertLayout($this->User),null);

    }
    public function testCCSaveUser(){
        $ccSave = new \App\Object\Users\CCSave();
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->andReturn('Users/edit/'.$this->User['id']);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->request = new ParameterBag(['user_name' => 'panit',
            'email'=>'test@testtest.com',
            'role_id'=>4,
            'supervisor_id'=>9,
            'remember_token'=>'Token'
        ]);
        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', '{objectName}/edit/{record?}', []))->bind($request);
        });
        $this->assertNotEquals($request,null);
        $this->assertEquals($ccSave->checkPermission($request),true);
        $this->assertEquals($ccSave->saveValue($request,$this->User),$this->User);
    }

}
