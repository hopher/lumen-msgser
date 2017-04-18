<?php

namespace MsgService\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use MsgService\Services\ShortMsgService;

class ShortMsgController extends Controller
{
    protected $shortMsgService;

    public function __construct(ShortMsgService $shortMsgService)
    {
        $this->shortMsgService = $shortMsgService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->shortMsgService->setMobile($request->input('mobile'));        // 手机号
        $this->shortMsgService->setCaptcha($request->input('captcha'));      // 短信验证码
        $this->shortMsgService->setSignature($request->input('signature'));  // 频道签名，如：【点看宁波】、【视听襄阳】

        try {
            $this->shortMsgService->send();
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'no',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
