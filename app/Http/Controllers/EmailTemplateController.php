<?php
/**
 * Class EmailTemplateController
 *
 * PHP Version >= 8.1
 *
 * @category EmailTemplateController
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Validation\ValidationException;

/**
 * Class EmailTemplateController
 *
 * PHP Version >= 8.1
 *
 * @category EmailTemplateController
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the email templates.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $templates = EmailTemplate::all();
        $groups = CustomerGroup::all();

        return response()->json([
            'groups' => $groups,
            'templates' => $templates
        ]);
    }

    /**
     * Store a newly created email template in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'subject' => 'required|string|max:255',
                'body_template' => 'required|string',
            ]);

            $data['user_id'] = auth()->user()->id;

            EmailTemplate::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Template created successfully!',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Send emails immediately.
     *
     * @param  Request $request
     * @return Response
     */
    public function send(Request $request)
    {
        $template = EmailTemplate::find($request->input('emailTemplates'));
        $group = CustomerGroup::find($request->input('emailGroups'));

        foreach ($group->customers as $customer) {
            $subject = $template->subject;
//            $body = preg_replace(['/{first_name}/', '/{last_name}/', '/{email}/'], [$customer->first_name, $customer->last_name, $customer->email], $template->body);
            $body =  $template->body;
            sendEmail($subject, $body, $customer->email);
        }

        return response()->json(['message' => 'Emails sent successfully']);
    }
}
