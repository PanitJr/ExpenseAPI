<?php
/**
 * Created by PhpStorm.
 * User: panit
 * Date: 3/29/2017
 * Time: 9:24 PM
 */


use app\Http\Controllers\ExpensePDF;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Object\Expense\CCDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\ParameterBag;


class ExpensePDFTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    protected $RequestContent;
    protected $request;
    public function setUp(){
        parent::setUp();
        Auth::loginUsingId(1001);
        $Expense = new \App\Object\Expense\Expense();
        $Expense->expensename = 'test_expense_3';
        $Expense->total_price = 1500;
        $Expense->user_id = 1001;
        $Expense->status = 1;
        $Expense->opportunity = 99;
        $Expense->approver = 9;
        $Expense->save();
        $this->RequestContent = "{
      \"id\": 783,
      \"expensename\": \"yaya-Expense-783\",
      \"total_price\": \"1707.00\",
      \"user_id\": 9,
      \"status\": 3,
      \"opportunity\": 24,
      \"approver\": 9,
      \"approveAvilable\": false,
      \"entity\": {
        \"id\": 783,
        \"ownerid\": 9,
        \"createid\": 9,
        \"modifiedby\": 9,
        \"created_at\": \"2017-02-06 03:02:09\",
        \"updated_at\": \"2017-02-06 03:02:10\",
        \"deleted\": 0,
        \"label\": \"Expense\"
      },
      \"items\": [
        {
          \"id\": 105,
          \"itemname\": \"Panit-Develop-Item-105\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Chidlom To Siam\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 106,
          \"itemname\": \"Panit-Develop-Item-106\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Chidlom To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-03-06\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 107,
          \"itemname\": \"Panit-Develop-Item-107\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Chidlom To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 108,
          \"itemname\": \"Panit-Develop-Item-108\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Chidlom To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 109,
          \"itemname\": \"Panit-Develop-Item-109\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"25.00\",
          \"description\": \"Wongwian Yai To Chidlom\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 186,
          \"itemname\": \"Panit-Develop-Item-186\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Wongwian Yai To Chidlom\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 187,
          \"itemname\": \"Panit-Develop-Item-187\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Wongwian Yai To Chidlom\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 188,
          \"itemname\": \"Panit-Develop-Item-188\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Siam To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 189,
          \"itemname\": \"Panit-Develop-Item-189\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Siam To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 190,
          \"itemname\": \"Panit-Develop-Item-190\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Siam To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 229,
          \"itemname\": \"Panit-Develop-Item-229\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Siam To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 344,
          \"itemname\": \"Panit-Develop-Item-344\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Siam To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 421,
          \"itemname\": \"Panit-Develop-Item-421\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Siam To Wongwian Yai\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 422,
          \"itemname\": \"Panit-Develop-Item-422\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Wongwian Yai To Siam\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 461,
          \"itemname\": \"Panit-Develop-Item-461\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"52.00\",
          \"description\": \"Wongwian Yai To Siam\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 462,
          \"itemname\": \"Panit-Develop-Item-462\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"456.00\",
          \"description\": \"Taxi To ACT2000\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 502,
          \"itemname\": \"Panit-Develop-Item-502\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"456.00\",
          \"description\": \"Taxi To ACT2000\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        },
        {
          \"id\": 503,
          \"itemname\": \"Panit-Develop-Item-503\",
          \"category\": 1,
          \"opportunity\": 24,
          \"cost\": \"42.00\",
          \"description\": \"Wongwian Yai To Ari\",
          \"attachment\": \"\",
          \"status\": 4,
          \"date\": \"2017-02-05\",
          \"expense_id\": 783,
          \"retrive_category\": {
            \"id\": 1,
            \"name\": \"Travel\"
          }
        }
      ],
      \"retrive_status\": {
        \"id\": 3,
        \"name\": \"Paid\"
      },
      \"retrive_opportunity\": {
        \"id\": 24,
        \"name\": \"MQDC\",
        \"active\": 1
      },
      \"retrive_approve\": [
        {
          \"id\": 1,
          \"expense\": 783,
          \"user\": 9,
          \"action\": 2,
          \"Date\": \"2017-02-25 12:06:18\",
          \"Comment\":\"Good job\",
          \"status\": {
            \"id\": 2,
            \"name\": \"Supervisor Approve\"
          },
          \"retrieve_user\": {
            \"id\": 9,
            \"user_name\": \"MOjune\",
            \"email\": \"panit@crm-c.club\",
            \"created_at\": null,
            \"updated_at\": \"2016-12-24 14:25:25\",
            \"firstname\": \"Panit\",
            \"lastname\": \"Jaijaroen\",
            \"role_id\": 4,
            \"supervisor_id\": 9,
            \"status\": 1
          }
        },
        {
          \"id\": 2,
          \"expense\": 783,
          \"user\": 9,
          \"action\": 1,
          \"Date\": \"2017-02-25 17:55:37\",
          \"Comment\":\"Good job\",
          \"status\": {
            \"id\": 1,
            \"name\": \"Admin Approve\"
          },
          \"retrieve_user\": {
            \"id\": 9,
            \"user_name\": \"Panit-Develop\",
            \"email\": \"panit@crm-c.club\",
            \"created_at\": null,
            \"updated_at\": \"2016-12-24 14:25:25\",
            \"firstname\": \"Panit\",
            \"lastname\": \"Jaijaroen\",
            \"role_id\": 4,
            \"supervisor_id\": 9,
            \"status\": 1
          }
        },
        {
          \"id\": 4,
          \"expense\": 783,
          \"user\": 9,
          \"action\": 4,
          \"Date\": \"2017-02-26 19:21:39\",
          \"Comment\":\"Nothing\",
          \"status\": {
            \"id\": 4,
            \"name\": \"Paid\"
          },
          \"retrieve_user\": {
            \"id\": 9,
            \"user_name\": \"K1\",
            \"email\": \"panit@crm-c.club\",
            \"created_at\": null,
            \"updated_at\": \"2016-12-24 14:25:25\",
            \"firstname\": \"Panit\",
            \"lastname\": \"Jaijaroen\",
            \"role_id\": 4,
            \"supervisor_id\": 9,
            \"status\": 1
          }
        }
      ],
      \"user\": {
        \"id\": 9,
        \"user_name\": \"Panit-Develop\",
        \"email\": \"panit@crm-c.club\",
        \"created_at\": null,
        \"updated_at\": \"2016-12-24 14:25:25\",
        \"firstname\": \"Panit\",
        \"lastname\": \"Jaijaroen\",
        \"role_id\": 4,
        \"supervisor_id\": 9,
        \"status\": 1
      },
      \"retrive_approver\": {
        \"id\": 9,
        \"user_name\": \"Panit-Develop\",
        \"email\": \"panit@crm-c.club\",
        \"created_at\": null,
        \"updated_at\": \"2016-12-24 14:25:25\",
        \"firstname\": \"Panit\",
        \"lastname\": \"Jaijaroen\",
        \"role_id\": 4,
        \"supervisor_id\": 9,
        \"status\": 1
      }
    }";
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->times()
            ->andReturn('api/Expense/ExpensePdf/'.$Expense->id);

        app()->instance('request', $requestMock->getMock());

        $request = request();
        $request->initialize();
        $request->setRouteResolver(function () use ($request) {
            return (new Route('Post', 'api/{objectName}/ExpensePdf/{record?}', []))->bind($request);
        });
        $request->content = $this->RequestContent;
        $this->request = $request;
    }
    public function testProcess(){
        $expensePdf = new App\Object\Expense\ExpensePdf();
        $res = $expensePdf->process($this->request);
        var_dump($res);
        $this->assertArrayHasKey('success',$res);
        $this->assertArrayHasKey('url',$res);
        $this->assertTrue($res['success']);
        $this->assertNotEquals(null,$res['url']);
    }
    public function testCheckPermission(){
        $expensePdf = new App\Object\Expense\ExpensePdf();
        Auth::loginUsingId(1000);
        $this->assertTrue($expensePdf->checkPermission($this->request));
        Auth::loginUsingId(1001);
        $this->assertTrue($expensePdf->checkPermission($this->request));
        Auth::loginUsingId(1003);
        $this->assertFalse($expensePdf->checkPermission($this->request));
    }
}
