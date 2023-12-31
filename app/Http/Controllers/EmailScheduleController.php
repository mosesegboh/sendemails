<?php
/**
 * Class EmailScheduleController
 *
 * PHP Version >= 8.1
 *
 * @category EmailScheduleController
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSchedule;
/**
 * Class EmailScheduleController
 *
 * PHP Version >= 8.1
 *
 * @category EmailScheduleController
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
class EmailScheduleController extends Controller
{
    /**
     * Store a newly created email schedule in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email_template_id' => 'required|exists:email_templates,id',
            'group_id' => 'required|exists:customer_groups,id',
            'scheduled_time' => 'required|date|after:now'
        ]);

        EmailSchedule::create($data);

        return response()->json(['message' => 'Emails scheduled successfully']);
    }
}
