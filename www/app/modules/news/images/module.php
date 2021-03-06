<?php


gs_dict::append(array(
		'LOAD_IMAGES'=>'добавить картинки',
	));


class module_news_images  extends gs_base_module implements gs_module {
	function __construct() { }
	function install() {
		foreach(array('tw_news_images','tw_news_images_files') as $r){
			$this->$r=new $r;
			$this->$r->install();
		}
	}
	function get_menu() { }
	
	static function get_handlers() {
		$data=array(
		'handler'=>array(
			'/admin/form/tw_news_images'=>array(
							'gs_base_handler.post:{name:admin_form.html:classname:tw_news_images:form_class:g_forms_html:return:gs_record}',
							'gs_base_handler.redirect',
							),
			'list'=>'gs_base_handler.show',
		),
	);
	$d=self::add_subdir($data,dirname(__file__));
	return $d;
	}
}

class tw_news_images extends tw_images {
	static $parent_id_name='Parent_id';
	function __construct($init_opts=false) {
		parent::__construct( array(
			//'Name'=> "fString 'Название' required=false",
			'Parent'=>"lOne2One tw_news mode=link",
			'File'=>"lOne2One tw_news_images_files 'File' hidden=false widget=include_form",
		),$init_opts);
		$this->structure['fkeys']=array(
			array('link'=>'Parent','on_delete'=>'CASCADE','on_update'=>'CASCADE'),
		);
	}
}

class tw_news_images_files extends tw_file_images {
	function __construct($init_opts=array()) {
		parent::__construct($init_opts);
		$this->structure['fkeys']=array(
			array('link'=>'tw_news_images.File','on_delete'=>'CASCADE','on_update'=>'CASCADE'),
		);

	}
	
	function config_previews() {
		parent::config_previews();
		$this->config=array_merge($this->config,array(
			'admin'=>array('width'=>50,'height'=>50,'method'=>'use_height','bgcolor'=>array(200,200,200)),
			'small'=>array('width'=>100,'height'=>100,'method'=>'use_box','bgcolor'=>array(200,200,200)),
			'gallery'=>array('width'=>150,'height'=>150,'method'=>'use_height','bgcolor'=>array(200,200,200)),
			'medium'=>array('width'=>200,'height'=>200,'method'=>'use_box','bgcolor'=>array(200,200,200)),
		));
	}
}



?>
