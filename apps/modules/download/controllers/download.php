<?php
class download extends MY_Controller{

	public function __construct()
	{
		$this->load->model('download/download_model');
	}

	public function index()
    {
        redirect(base_url());
	}

    public function inspection($id)
    {
        return $this->download_model->setDownloadInspection($id);
    }

    public function letter($id)
    {
        return $this->download_model->setDownloadLetterRecom($id);
    }

}
?>