<?php

namespace MsgService\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use MsgService\Services\VoiceCodeService;

class VoiceCodeController extends Controller
{

    public function __construct(VoiceCodeService $voiceCodeService)
    {
        $this->voiceCodeService = $voiceCodeService;
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
        $this->voiceCodeService->setMobile($request->input('mobile'));        // 手机号
        $this->voiceCodeService->setCaptcha($request->input('captcha'));      // 短信验证码
        $this->voiceCodeService->setSignature($request->input('signature'));  // 频道签名，如：【点看宁波】、【视听襄阳】

        try {
            $this->voiceCodeService->send();
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
