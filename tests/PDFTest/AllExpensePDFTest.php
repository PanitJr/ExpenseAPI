<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 3/29/2017
 * Time: 9:24 PM
 */



use app\Http\Controllers\AllExpensePDFController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;


class AllExpensePDFTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $RequestContent;
    protected $request;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(1000);
        $this->RequestContent = "{
    \"header\": {
      \"expense_name\": \"expensename\",
      \"Opportunity\": \"opportunity\",
      \"Status\": \"status\",
      \"Total Price\": \"total_price\"
    },
    \"listInfo\": {
      \"total\": 3,
      \"per_page\": 999999,
      \"current_page\": 1,
      \"last_page\": 1,
      \"next_page_url\": null,
      \"prev_page_url\": null,
      \"from\": 1,
      \"to\": 3,
      \"data\": [
        {
          \"id\": 783,
          \"expensename\": \"Panit-Develop-Expense-783\",
          \"opportunity\": 24,
          \"status\": 3,
          \"total_price\": \"1707.00\",
          \"retrive_status\": {
            \"id\": 3,
            \"name\": \"Paid\"
          },
          \"retrive_opportunity\": {
            \"id\": 24,
            \"name\": \"MQDC\",
            \"active\": 1
          },
          \"entity\": {
            \"id\": 783,
            \"ownerid\": 9,
            \"createid\": 9,
            \"modifiedby\": 9,
            \"created_at\": \"2017-02-06 03:02:09\",
            \"updated_at\": \"2017-02-06 03:02:10\",
            \"deleted\": 0,
            \"label\": \"Expense\"
          }
        },
        {
          \"id\": 827,
          \"expensename\": \"Panit-Develop-Expense-827\",
          \"opportunity\": 24,
          \"status\": 1,
          \"total_price\": \"1787.00\",
          \"retrive_status\": {
            \"id\": 1,
            \"name\": \"New\"
          },
          \"retrive_opportunity\": {
            \"id\": 24,
            \"name\": \"MQDC\",
            \"active\": 1
          },
          \"entity\": {
            \"id\": 827,
            \"ownerid\": 9,
            \"createid\": 9,
            \"modifiedby\": 9,
            \"created_at\": \"2017-04-10 09:21:53\",
            \"updated_at\": \"2017-04-10 09:21:54\",
            \"deleted\": 0,
            \"label\": \"Expense\"
          }
        },
        {
          \"id\": 828,
          \"expensename\": \"Panit-Develop-Expense-828\",
          \"opportunity\": 25,
          \"status\": 1,
          \"total_price\": \"52.00\",
          \"retrive_status\": {
            \"id\": 1,
            \"name\": \"New\"
          },
          \"retrive_opportunity\": {
            \"id\": 25,
            \"name\": \"SLC\",
            \"active\": 1
          },
          \"entity\": {
            \"id\": 828,
            \"ownerid\": 9,
            \"createid\": 9,
            \"modifiedby\": 9,
            \"created_at\": \"2017-04-10 09:21:54\",
            \"updated_at\": \"2017-04-10 09:21:55\",
            \"deleted\": 0,
            \"label\": \"Expense\"
          }
        }
      ]
    },
    \"listFilters\": {
      \"userlis\": [
        {
          \"id\": 1000,
          \"user_name\": \"Admin-ForTest\"
        },
        {
          \"id\": 15,
          \"user_name\": \"chanakan@crm-c.club\"
        },
        {
          \"id\": 661,
          \"user_name\": \"Earnsis\"
        },
        {
          \"id\": 1003,
          \"user_name\": \"Employee-1-ForTest\"
        },
        {
          \"id\": 1004,
          \"user_name\": \"Employee-2-ForTest\"
        },
        {
          \"id\": 663,
          \"user_name\": \"Min\"
        },
        {
          \"id\": 659,
          \"user_name\": \"Mojune\"
        },
        {
          \"id\": 660,
          \"user_name\": \"Nadech\"
        },
        {
          \"id\": 657,
          \"user_name\": \"Natcha\"
        },
        {
          \"id\": 35,
          \"user_name\": \"P'Fha\"
        },
        {
          \"id\": 14,
          \"user_name\": \"Panit Employee\"
        },
        {
          \"id\": 9,
          \"user_name\": \"Panit-Develop\"
        },
        {
          \"id\": 1001,
          \"user_name\": \"Supervisor-1-ForTest\"
        },
        {
          \"id\": 1002,
          \"user_name\": \"Supervisor-2-ForTest\"
        },
        {
          \"id\": 658,
          \"user_name\": \"Taktiechada\"
        },
        {
          \"id\": 1,
          \"user_name\": \"UserAdmin-Dev\"
        },
        {
          \"id\": 662,
          \"user_name\": \"yaya\"
        }
      ],
      \"opplis\": [
        {
          \"id\": 24,
          \"name\": \"MQDC\"
        },
        {
          \"id\": 25,
          \"name\": \"SLC\"
        },
        {
          \"id\": 26,
          \"name\": \"SMPH\"
        }
      ],
      \"statuslis\": [
        {
          \"id\": 1,
          \"name\": \"New\"
        },
        {
          \"id\": 3,
          \"name\": \"Paid\"
        },
        {
          \"id\": 4,
          \"name\": \"Supervisor Approved\"
        },
        {
          \"id\": 5,
          \"name\": \"Rejected\"
        },
        {
          \"id\": 6,
          \"name\": \"Admin Approved\"
        }
      ]
    },
    \"total_price\": 3546
  }";

        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/AllExpensePdf');

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', 'api/{objectName}/AllExpensePdf', []))->bind($request);
        });
        $request->content = $this->RequestContent;
        $this->request = $request;
    }
    public function testProcess(){
        $allExpensePdf = new App\Object\Expense\AllExpensePdf();
        $res = $allExpensePdf->process($this->request);
        var_dump($res);
        $this->assertArrayHasKey('success',$res);
        $this->assertArrayHasKey('url',$res);
        $this->assertTrue($res['success']);
        $this->assertNotEquals(null,$res['url']);
    }
    public function testCheckPermission(){
        $expensePdf = new App\Object\Expense\AllExpensePdf();
        Auth::loginUsingId(1000);
        $this->assertTrue($expensePdf->checkPermission($this->request));
        Auth::loginUsingId(1001);
        $this->assertFalse($expensePdf->checkPermission($this->request));
        Auth::loginUsingId(1003);
        $this->assertFalse($expensePdf->checkPermission($this->request));
    }
}
