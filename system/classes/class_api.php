<?php
class api {
	public function __construct()
	{
		global $C;
		$this->network	= & $GLOBALS['network'];
		$this->cache	= & $GLOBALS['cache'];
		$this->db		= & $GLOBALS['db'];
		$this->core =  & $GLOBALS['core'];
		$this->page		= & $GLOBALS['page'];
		$this->api	= & $GLOBALS['api'];
		$this->phone	= & $GLOBALS['phone'];
		$this->request	= array();
		$this->params	= new stdClass;
		$this->params->user	= FALSE;
		$this->params->group	= FALSE;
		$this->title	= NULL;
		$this->html		= NULL;
		$this->controllers	= 	$C->path_controllers;
		$this->lang_data		= array();
		$this->tpl_name	 	= $C->name_template;
		$this->inputs = false;
		$this->output = false;
	}
	function output($output,$just_return=false){
		global $C,$D;
		$this->output = $output;
		if($just_return)
			return $output;
		$this->page->load_langfile("global.php");
		//header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");//removable
		$response_code = !isset($C->force_200_status)?(isset($output->status)?$output->status:400):200;
		http_response_code ($response_code);
		if(isset($output->message) && $output->message!=null)
			$output->message = $this->page->lang($output->message);
		$json = json_encode($output);
		if($output!=null){
			/*
			if(1==1||isset($D->merchant_business)&&!!$D->merchant_business){
				$information = json_encode((object) [
					"IP"=>IP(),
					"URL"=>$C->FULL_URL,
					"GET"=>(object)$_GET,
					"POST"=>(object)$_POST,
					"RESPONSE"=>(object)$output,
				]);
				$this->core->add_webservice_request(!!$D->merchant_business?$D->merchant_business->user_id:null,!!$D->merchant_business?$D->merchant_business->id:null,$response_code,$information);
			}
			*/
			echo $json;
		}
		exit;
	}
	function setInputs($array){
		$this->inputs = $array;
	}
	function inputs($array=false,$just_return=false){
		if(!$array)
			$array = $this->inputs;
		//parse_str(file_get_contents("php://input"),$inputs);
        $inputs = $_REQUEST;
		if(isset($_SERVER["CONTENT_TYPE"])&&strtolower($_SERVER["CONTENT_TYPE"])=="application/json"){
			$inputs = json_decode(file_get_contents('php://input'), true);
		}
		$result = (object) [];
		$result->status = 200;
		$result->fields = (object)[];

		//echo "<form action=\"\" method=\"post\">";
        $i = 0;
        //$output = (object)  ["action"=>str_replace("/pardakht/app/users/","",$_SERVER['REQUEST_URI']),"fields"=>[],"onSuccess"=>null,"onFailed"=>null];
        
		foreach($array as $key=>$input){
			//urldecode
			if(isset($inputs[$input->name]) && !is_object($inputs[$input->name]) && !is_array($inputs[$input->name]))
				$inputs[$input->name] = urldecode($inputs[$input->name]);
			elseif(isset($inputs[$input->name]) && is_array($inputs[$input->name])){
				$inputs[$input->name] = $inputs[$input->name];
			}
			//required
			if($input->required && ( !isset($inputs[$input->name]) || $inputs[$input->name]=="" ) ){
				$tmp_input = new stdClass;
				$tmp_input->error = $this->page->lang("required");
				$tmp_input->value = $inputs[$input->name];
				$result->fields->{$input->name} = $tmp_input;
				continue;
			}elseif(!isset($inputs[$input->name]) || $inputs[$input->name]===null || $inputs[$input->name]===""){
				$result->fields->{$input->name} = isset($input->default)?$input->default:null;
				continue;
			}
			//language
            if(isset($input->lang)){
				if($input->lang == "persian"){
					if(!is_rtl($inputs[$input->name])){
						$tmp_input = new stdClass;
						$tmp_input->error = $this->page->lang("writePersian");
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;;
					}
				}else if($input->lang == "english"){
					if(is_rtl($inputs[$input->name])){
						$tmp_input = new stdClass;
						$tmp_input->error = $this->page->lang("writeEnglish");
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				}
            }
			//length
			if(isset($inputs[$input->name]) && isset($input->length) && mb_strlen($inputs[$input->name])!=$input->length ){
				$tmp_input = new stdClass;
				$tmp_input->error = "lengthError";
				$tmp_input->value = $inputs[$input->name];
				$result->fields->{$input->name} = $tmp_input;;
			}
			//maxLength
			if(isset($inputs[$input->name]) && isset($input->max_length) && mb_strlen($inputs[$input->name])>$input->max_length ){
				$tmp_input = new stdClass;
				$tmp_input->error = "maxLengthError";
				$tmp_input->value = $inputs[$input->name];
				$result->fields->{$input->name} = $tmp_input;
			}
			//max
			if(isset($inputs[$input->name]) && isset($input->max) && $inputs[$input->name]>=$input->max ){
				$tmp_input = new stdClass;
				$tmp_input->error = "maxError";
				$tmp_input->value = $inputs[$input->name];
				$result->fields->{$input->name} = $tmp_input;
			}
			//min
			if(isset($inputs[$input->name]) && isset($input->min) && $inputs[$input->name]<=$input->min ){
				$tmp_input = new stdClass;
				$tmp_input->error = "minError";
				$tmp_input->value = $inputs[$input->name];
				$result->fields->{$input->name} = $tmp_input;
			}
			//min length
			if(isset($inputs[$input->name]) && isset($input->min_length) && mb_strlen($inputs[$input->name])<$input->min_length ){
				$tmp_input = new stdClass;
				$tmp_input->error = "minLengthError";
				$tmp_input->value = $inputs[$input->name];
				$result->fields->{$input->name} = $tmp_input;
			}
			/* check with type */
			switch($input->type){
				case "image":
					$tmp = $this->network->temporary_get($inputs[$input->name]);
					if(!isset($tmp->path)||!file_exists($tmp->path) || !getimagesize($tmp->path)){
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}else{
						$inputs[$input->name] = $tmp;
					}
				break;
				case "timestamp":
					$inputs[$input->name] = round($inputs[$input->name]/1000);
					if(!is_numeric($inputs[$input->name])){
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "number":
					if(!ctype_digit($inputs[$input->name])){
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
					break;
				case "enum":
					if(!in_array(intval($inputs[$input->name]),$input->allowed_values)){
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "string":

				break;
				case "card":
					$inputs[$input->name] = str_replace(["_","-"," ","	"],"",strtolower($inputs[$input->name]));
					if(ctype_digit($inputs[$input->name]) && strlen($inputs[$input->name])==16){
						$inputs[$input->name] = $inputs[$input->name];
					}else{
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "iban":
					$inputs[$input->name] = str_replace(["ir"," ","	"],"",strtolower($inputs[$input->name]));
					
					if(ctype_digit($inputs[$input->name]) && strlen($inputs[$input->name])==24){
						$inputs[$input->name] = "IR".$inputs[$input->name];
					}else{
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "url":
					if (substr($inputs[$input->name],0,4)!=="http") {
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "range":
					$_min = intval($inputs[$input->name][0]);
					$_max = intval($inputs[$input->name][1]);
					if ($_max>0 && $_max<$_min) {
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "domain":
					$inputs[$input->name] = str_replace(["http://","https://","www."],"",$inputs[$input->name]);
					if (!filter_var(gethostbyname($inputs[$input->name]), FILTER_VALIDATE_IP)) {
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "phone":
					$phone = $this->phone->parse('IR',$inputs[$input->name]);
					if(!$phone || strlen($phone)!=13){
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}else{
						$inputs[$input->name] = $phone;
					}
				break;
				case "telephone":
					$inputs[$input->name] = str_replace(["-","_",".",","],"",$inputs[$input->name]);
					if(!ctype_digit($inputs[$input->name])){
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				case "mail":
					if (!filter_var($inputs[$input->name], FILTER_VALIDATE_EMAIL)) {
						$tmp_input = new stdClass;
						$tmp_input->error = "invalidFormat_".$input->name;
						$tmp_input->value = $inputs[$input->name];
						$result->fields->{$input->name} = $tmp_input;
					}
				break;
				default:
				break;
			}
			if(!isset($result->fields->{$input->name}))
				$result->fields->{$input->name} = isset($inputs[$input->name])?$inputs[$input->name]:(isset($input->default)?$input->default:null);
		}
		//echo "<input type=\"submit\" /></form>";
        //echo json_encode($output);


		foreach($result->fields as $_input_name=>$_item)
		{
			if(empty($_item->error))
				continue;
			$result->fields->{$_input_name}->error = $this->page->lang($_item->error);
			$result->message = $_input_name.' : '.$_item->error;
			$result->status = 400;
			break;
		}
		if($result->status!=200){
			if(!empty($result->message))
				$result->message = "pleaseFixFieldsErrors";
			return $this->output($result,$just_return);
		}else{
			return $this->output($result,$just_return);
			return $result;
		}
	}
	function html(){
		GLOBAL $C;
		$_html = "";
		foreach($this->inputs as $_input)
		{
			// var_dump($_input);
			$_html .= '<div class="form_group">';
			$_html .= '<label>'.(isset($_input->label)?$this->page->lang($_input->label):$this->page->lang($_input->name)).'</label>';
			if(!isset($_input->value))
				$_input->value = "";
			if(!!$this->output && isset($this->output->fields))
			{
				if(is_object($this->output->fields->{$_input->name}))
					$_input->value = $this->output->fields->{$_input->name}->value;
				elseif(is_string($this->output->fields->{$_input->name})||is_array($this->output->fields->{$_input->name}))
					$_input->value = $this->output->fields->{$_input->name};
				else
					$_input->value = "";
			}
			
			if(empty($_input->value) && isset($_input->default))
				$_input->value = $_input->default;
				
			if(!isset($_input->placeholder))
				$_input->placeholder = "";

			$_html .= '<div class="form_field_container">';
			switch($_input->type)
			{
				case "checkbox":
					foreach($_input->options as $_option)
					$_html .= '<label>'.htmlspecialchars($_option->label).'<input class="form_field" type="checkbox" '.($_option->value==$_input->value?"checked":"").' value="'.htmlspecialchars($_option->value).'" name="'.$_input->name.'"></input></label><br />';
				break;
				case "radio":
					foreach($_input->options as $_option)
					$_html .= '<label>'.htmlspecialchars($_option->label).'<input class="form_field" type="radio" '.($_option->value==$_input->value?"checked":"").' value="'.htmlspecialchars($_option->value).'" name="'.$_input->name.'"></input></label><br />';
				break;
				case "select":
					$_html .= '<select class="form_field" name="'.$_input->name.'"><option></option>';
					foreach($_input->options as $_option){
						if(!isset($_option->value))
							$_option->value = $_option->id;
						$_html .= '<option " '.($_option->value==$_input->value?"selected":"").' value="'.htmlspecialchars($_option->value).'" >'.htmlspecialchars($_option->label).'</option>';
					}
					$_html .= "</select>";
				break;
				case "textarea":
					$_html .= '<textarea class="form_field" id="input_'.$_input->name.'" placeholder="'.$_input->placeholder.'" name="'.$_input->name.'">'.htmlspecialchars($_input->value).'</textarea>';
				break;
				case "string":case "text":case "phone":case "mail":
					$_html .= '<input class="form_field" type="text" id="input_'.$_input->name.'" placeholder="'.$_input->placeholder.'" name="'.$_input->name.'" value="'.htmlspecialchars($_input->value).'"></input>';
				break;
				case "number":case "price":
					$_html .= '<input class="form_field" type="number" id="input_'.$_input->name.'" placeholder="'.$_input->placeholder.'" name="'.$_input->name.'" value="'.htmlspecialchars($_input->value).'"></input>';
				break;
				case "range":
					$_html .= '<input style="width:50%;display:inline-block;" class="form_field" type="number" id="input_'.$_input->name.'" name="'.$_input->name.'[0]" value="'.(isset($_input->value[0])&&$_input->value[0]!=0?htmlspecialchars($_input->value[0]):"").'"></input>';
					$_html .= '<input style="width:50%;display:inline-block;" class="form_field" type="number" id="input_'.$_input->name.'" name="'.$_input->name.'[1]" value="'.(isset($_input->value[1])&&$_input->value[1]!=0?htmlspecialchars($_input->value[1]):"").'"></input>';
				break;
				case "password":
					$_html .= '<input class="form_field" type="password" id="input_'.$_input->name.'" placeholder="'.$_input->placeholder.'" name="'.$_input->name.'" value="'.htmlspecialchars($_input->value).'"></input>';
				break;
				case "category":
					$_start_parent_id = 0;
					$_selected_category_id = 0;
					if(!empty($_input->value)){
						$_selected_category = $this->core->get_category_by_id($_input->value);
						if($_selected_category){
							$_selected_category_id = $_selected_category->id;
							$_start_parent_id = $_selected_category->parent_id;
						}
					}
					$_html .= '
					<select class="form_field" size="5" id="input_'.$_input->name.'" name="'.$_input->name.'">
					</select>
					<script>
						function load_categories($parent_id){
							$.get("'.$C->SITE_URL.'ajax/categories/id:"+$parent_id, function(data, status){
								var json_data = JSON.parse(data);
								if(json_data.result.length==0)
								{
									$("#submit_category").removeAttr("disabled");
									return;
								}else{
									$("#submit_category").attr("disabled","true");
								}
								$("#input_'.$_input->name.'").html("");
								if($parent_id!=0){
									$("#input_'.$_input->name.'").append($("<option>", { 
										value: json_data.back_category_id,
										text : "<<"
									}));
								}
								for(i in json_data.result){
									attributes = {
										value: json_data.result[i].id,
										text : json_data.result[i].name
									};
									if('.$_selected_category_id.'==json_data.result[i].id)
										attributes.selected = true;
									$("#input_'.$_input->name.'").append($("<option>", attributes));
								}
							});
						}
						load_categories('.$_start_parent_id.');
						$("#input_'.$_input->name.'").on("change", function() {
							load_categories( this.value );
						});
					</script>
					';
				break;
				case "city":
					$_html .= '<input class="form_field" placeholder="'.$_input->placeholder.'" type="text" id="input_'.$_input->name.'" value="'.htmlspecialchars($_input->value).'"></input><input id="input_'.$_input->name.'_val"  type="hidden" name="'.$_input->name.'"></input>';
					$_html .= '<script>
					$( function() {
					  $( "#input_'.$_input->name.'" ).autocomplete({
						source: function( request, response ) {
						  $.ajax( {
							url: SITE_URL+"ajax/cities",
							dataType: "jsonp",
							data: {
							  query: request.term
							},
							success: function( data ) {
							  response( data );
							}
						  } );
						},
						minLength: 2,
						select: function( event, ui ) {
							$( "#input_'.$_input->name.'" ).val( ui.item.label );
							$( "#input_'.$_input->name.'_val" ).val( ui.item.value );
							'.(isset($_input->force_redirect)&&$_input->force_redirect?'window.location.replace(ui.item.url);':"").'
							return false;
						}
					  } ).autocomplete( "instance" )._renderItem = function( ul, item ) {
						return $( "<li>" )
						  .append( "<span class=\"label\">" + item.label + "</span><span class=\"more-info\">" + item.desc + "</span>" )
						  .appendTo( ul );
					  };
					} );
					</script>';
				break;
				case "media":
					$_upload_box_id = 'input_'.$_input->name;
					$_html .= '<div class="form_field"><ul class="media_conatainer" id="file_list_'.$_upload_box_id.'"></ul><label id="'.$_upload_box_id.'"  for="'.$_input->name.'" class="uploader"><h3>'.$this->page->lang("DragAndDropFilesHere").'<h3/><div class="btn"> <span>'.$this->page->lang("OpenTheFileBrowser").'</span> <input id="'.$_input->name.'" type="file" title="Click to add Files" multiple=""> </div></label></div>';
					$_html .= '<script type="text/html" id="files-template"> <li class="media"> <span class="remove_upload_file"><i class="fa-solid fa-trash-can"></i></span><img src="%%filename%%" alt="Generic placeholder image"> <div class="media-body mb-1"> <p class="mb-2"> Status: <span class="text-muted">Waiting</span> </p></div> </li> </script>';
						$_media_loader = '';
						if(is_array($_input->value) && count($_input->value)>0){
							foreach($_input->value as $item)
							{
								if(!isset($item->id))continue;
							$_media_loader .= '
								ui_multi_add_already_file("#file_list_'.$_upload_box_id.'","'.$item->id.'", "'.$item->url.'");
							';
							}
						}
					$_html .= '<script>
							$("#'.$_upload_box_id.'").dmUploader({
								url: SITE_URL+"upload",
								max:3,
								fieldName:"file",
								maxFileSize: 10000000, // 3 Megs 
								allowedTypes: "image/*",
								multiple:true,
								extFilter: ["jpg", "jpeg","png","gif"],
								listId : "file_list_'.$_upload_box_id.'",
								boxId : "'.$_upload_box_id.'",
								onDragEnter: function(){
								// Happens when dragging something over the DnD area
								this.addClass("active");
								},
								onDragLeave: function(){
								// Happens when dragging something OUT of the DnD area
								this.removeClass("active");
								},
								onInit: function(){
								// Plugin is ready to use
								//toast("Penguin initialized :)","info");
								'.$_media_loader.'
								},
								onComplete: function(){
								// All files in the queue are processed (success or error)
								//toast("All pending tranfers finished");
								},
								onNewFile: function(id, file){
								// When a new file is added using the file selector or the DnD area
								console.log("New file added #" + id);
								ui_multi_add_file("#file_list_'.$_upload_box_id.'",id, file);

								if (typeof FileReader !== "undefined"){
									var reader = new FileReader();
									var img = $("#uploaderFile" + id).find("img");
									
									reader.onload = function (e) {
									img.attr("src", e.target.result);
									}
									reader.readAsDataURL(file);
								}
								},
								onBeforeUpload: function(id){
								// about tho start uploading a file
								//toast("Starting the upload of #" + id);
								show_loading(null);
								ui_multi_update_file_progress(id, 0, "", true);
								ui_multi_update_file_status(id, "uploading", "Uploading...");
								},
								onUploadProgress: function(id, percent){
								// Updating file progress
								ui_multi_update_file_progress(id, percent);
								},
								onUploadSuccess: function(id, data){
									data = JSON.parse(data);
									document.getElementById("uploaderFile"+id).innerHTML += \'<input type=\"hidden\" name=\"'.$_input->name.'\[]" value=\"\'+data.information.reference+\'\"></input>\';
								// A file was successfully uploaded
								ui_multi_update_file_status(id, "success", "Upload Complete");
								ui_multi_update_file_progress(id, 100, "success", false);
									hide_loading();
								},
								onRemove: function(id,media_id=null){
								  ui_multi_remove_upload_file("#file_list_'.$_upload_box_id.'",id);
								  if(media_id!=null){
									$("#file_list_'.$_upload_box_id.'").append(\'<input type="hidden" name="delete_media[]" value="\'+media_id+\'"></input>\');
								  }
								},
								onUploadError: function(id, xhr, status, message){
								ui_multi_update_file_status(id, "danger", message);
								ui_multi_update_file_progress(id, 0, "danger", false);  
									hide_loading();
									toast(lang("FileShouldBePhoto"),lang("alert"));
								},
								onFallbackMode: function(){
								// When the browser doesnt support this plugin :(
								console.log("Plugin cant be used here, running Fallback callback", "danger");
								},
								onFileSizeError: function(file){
									toast(lang("FileSizeIsBig"),lang("alert"));
								console.log("File " + file.name + " cannot be added: size excess limit", "danger");
								},
								onFileTypeError: function(file){
									toast(lang("FileShouldBePhoto"),lang("alert"));
								},
								onFileExtError: function(file){
								
								}
							});
							</script>
						';
				break;
			}
			$_html .= '</div>';
			if(!!$this->output)
			{
				if(is_object($this->output->fields->{$_input->name}) && isset($this->output->fields->{$_input->name}->error))
					$_html .= '<div class="form_message">'.$this->output->fields->{$_input->name}->error.'</div>';
			}
			if(isset($_input->description)){
				$_html .= '<div id="form_description_'.$_input->name.'" class="form_description">'.$this->page->lang($_input->description).'</div>';
			}
			$_html .= '</div>';
		}
		return $_html;
	}
}
?>