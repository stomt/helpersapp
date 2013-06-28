<?php

class HelpController extends BaseController {

    /**
     * Help Repository
     *
     * @var Help
     */
    protected $help;

    public function __construct(Help $help)
    {
        $this->help = $help;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

   	/**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }
}