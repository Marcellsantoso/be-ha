<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LeapWebsite
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Home extends WebApps {

	public function index ()
	{
		Mold::plugin("Gallery", "gallery");
	}

	public function details ()
	{
		$details = new GalleryDetails();
		$details->showDetails();
	}

	public function about ()
	{
		PageWeb::portalIndex(PageWeb::ID_ABOUT);
	}

	public function terms ()
	{
		PageWeb::portalIndex(PageWeb::ID_TERMS);
	}

	public function contact ()
	{
		PageWeb::portalIndex(PageWeb::ID_CONTACT);
	}

	public function page ()
	{
		PageWeb::portalIndex();
	}

	public function docviewer ($param)
	{
		$ifw = new InputFileWeb();
		$ifw->show();
	}

	public function order ()
	{
		MailForm::mail();
	}

	public function receipt ()
	{
		Receipt::displayReceipt();
	}

	public function ask ()
	{
		Ask::askForm();
	}

	public function thankyou ()
	{
		Ask::thankyou();
	}
}
