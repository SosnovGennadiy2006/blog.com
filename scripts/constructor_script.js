var root            = document.querySelector(':root'),//В этом блоке хранятся все CSS переменные
	numberOfColumns = getComputedStyle(root).getPropertyValue('--number-of-columns');

var isGridSticky                      = false,
	isUserCanSelect                   = false,
	isUserCanSelectHorizontal         = false,
	isUserSelectText                  = false,
	isUserSelectRectangle             = false,
	isMouseDown                       = false,
	isCursorExitMainBlock             = false,
	isUserClickToSelect               = false,
	isUserHasChanges                  = false,
	lastTimeClickedBlock              = null,
	selectionBlockParent              = null,
	massivOfObjectsWhichUserClickedOn = [],
	isShiftDown                       = false,
	fontColors                        = {'#000000': 'black', '#a9a9a9': 'grey', '#696969': 'dark-grey', '#ffffff': 'white', '#ffa500': 'orange'};

var add_text_button                         = document.querySelector('.add_text .button_color'),
	add_header_button                       = document.querySelector('.add_header .button_color'),
	add_rectangle_button                    = document.querySelector('.add_rectangle .button_color'),
	choose_background_of_rectangle_button   = document.querySelector('.choose_background_of_rectangle_button'),
	choose_background_of_rectangle_block    = document.querySelector('.choose_background_of_rectangle_block'),
	dropdown_list_button_about_font_size    = document.querySelector('.font_size_settings .color'),
	dropdown_list_button_about_font_color   = document.querySelector('.font_color_settings .color'),
	dropdown_list_button_about_header_size  = document.querySelector('.header_size_settings .color'),
	dropdown_list_button_about_header_color = document.querySelector('.header_color_settings .color'),
	all_font_size_dropdown_list_items       = document.querySelectorAll('.font_size_settings .dropdown_list_choice'),
	all_font_color_dropdown_list_items      = document.querySelectorAll('.font_color_settings .dropdown_list_choice'),
	all_header_size_dropdown_list_items     = document.querySelectorAll('.header_size_settings .dropdown_list_choice'),
	all_header_color_dropdown_list_items    = document.querySelectorAll('.header_color_settings .dropdown_list_choice'),
	choose_font_size_button                 = document.querySelector('.choose_font_size .button_color'),
	choose_font_size_button_block           = choose_font_size_button.parentNode.parentNode,
	choose_font_color_button                = document.querySelector('.choose_font_color .button_color'),
	choose_font_color_button_block          = choose_font_color_button.parentNode.parentNode,
	choose_header_size_button               = document.querySelector('.choose_header_size .button_color'),
	choose_header_size_button_block         = choose_header_size_button.parentNode.parentNode,
	choose_header_color_button              = document.querySelector('.choose_header_color .button_color'),
	choose_header_color_button_block        = choose_header_color_button.parentNode.parentNode,
	text_about_how_add_text                 = document.querySelector('.about_text_selection'),
	text_about_how_add_header               = document.querySelector('.about_header_selection'),
	text_about_how_add_rectangle            = document.querySelector('.about_rectangle_selection'),
	dropdown_list_about_font_size           = document.querySelector('.font_size_settings'),
	dropdown_list_about_font_color          = document.querySelector('.font_color_settings'),
	dropdown_list_about_header_size         = document.querySelector('.header_size_settings'),
	dropdown_list_about_header_color        = document.querySelector('.header_color_settings');

var global_objects = [
						dropdown_list_button_about_font_size,
						dropdown_list_button_about_font_color,
						dropdown_list_button_about_header_size,
						dropdown_list_button_about_header_color,
						choose_font_size_button_block, 
						choose_font_color_button_block, 
						choose_header_size_button_block, 
						choose_header_color_button_block, 
						choose_background_of_rectangle_block, 
						text_about_how_add_text, 
						text_about_how_add_header, 
						text_about_how_add_rectangle, 
						dropdown_list_about_font_size, 
						dropdown_list_about_font_color,
						dropdown_list_about_header_size, 
						dropdown_list_about_header_color
					];

function makeOneGlobalObjectActive(object){
	clear_all(global_objects);
	clear_all(all_font_size_dropdown_list_items);
	clear_all(all_font_color_dropdown_list_items);
	clear_all(all_header_size_dropdown_list_items);
	clear_all(all_header_color_dropdown_list_items);

	if (object !== null) {
		object.classList.add('active');
	}
}

var list_items              = document.querySelectorAll('.item'),
	containers              = document.querySelectorAll('.settings_container'),
	settings_main_container = document.querySelector('.settings'),
	cross_settings          = document.querySelector('.settings_containers .cross');

function clear_all(massiv){
	massiv.forEach(item => item.classList.remove('active'));
}

function sleep(sec){
	return new Promise((resolve, reject) => {
		setInterval(() => resolve(), sec);
	});
}

var main_section = document.querySelector('.main_section_container_for_objects');

allow_block_to_be_selected(main_section);
allow_block_to_be_selected_by_horizontal(main_section);



function clickFunction(e){
	clear_all(list_items);
	clear_all(containers);
	if (e.target.classList.contains('item')){
		var n = e.target.getAttribute('data-n');
		e.target.classList.add('active');
		containers[n].classList.add('active');

		if (!settings_main_container.classList.contains('active')) {
			settings_main_container.classList.add('active');
		}
	}else{
		var target = e.target.parentNode,
			n      = target.getAttribute('data-n');
		target.classList.add('active');
		containers[n].classList.add('active');

		if (!settings_main_container.classList.contains('active')) {
			settings_main_container.classList.add('active');
		}
	}
}

cross_settings.onclick = () => {
	settings_main_container.classList.remove('active');
}

list_items.forEach(item => item.onclick = clickFunction);

var switch_buttons   = document.querySelectorAll(".switch"),
	grid             = document.querySelector(".grid"),
	else_about_grid  = document.querySelector(".else_about_grid");

switch_buttons.forEach(button => {
	button.onclick = e => {
		e.target.classList.toggle('active');
		if(e.target.classList.contains('makeGridActive')){
			grid.classList.toggle('active');
			else_about_grid.classList.toggle('active');
		}

		if(e.target.classList.contains('makeGridSticky')){
			if (isGridSticky) {
				isGridSticky = false;
			}else{
				isGridSticky = true;
			}
		}
	}
})

document.querySelector('.submitButton').onclick = () => {
	var post_content = document.querySelector('textarea.formContent'),
		post_name    = document.querySelector('.post_name input');


	if (post_content.value && post_name.value) {
		main_section = document.querySelector('.main_section_container_for_objects');
		main_section.childNodes.forEach(node => {

			node.classList.remove('userClickNode');
			node.removeAttribute('data-type');
			if (node.classList.contains('user_text')) {
				node.removeAttribute('autofocus');
				node.removeAttribute('placeholder');
				node.innerHTML = node.getAttribute('data-value');
				node.removeAttribute('data-value');
			} else if (node.classList.contains('user_header')) {
				node.removeAttribute('autofocus');
				node.removeAttribute('placeholder');
				node.innerHTML = node.getAttribute('data-value');
				node.removeAttribute('data-value');
			}
		})

		post_content.value = main_section.innerHTML;
		console.log(post_content.value);
	}
	isUserHasChanges = false;
	window.onbeforeunload = none;
}











function onButtonClick(isRow, visibility_buttons, fill_buttons, delete_buttons, informationAboutFunction){
	try{
		visibility_buttons.forEach(button => {
			button.onclick = e => {
				var layer_number = e.target.parentNode.parentNode.parentNode.getAttribute('data-n'),
					img          = e.target.childNodes[1],
					layers       = document.querySelectorAll('.grid table tr');

				var img_src = img.getAttribute('src');

				if (img_src == '/imgs/visibility.png') {
					img.src = '/imgs/not-visibility.png';
					layers[layer_number - 1].classList.add('not-visibile');
				}else{
					img.src = '/imgs/visibility.png';
					layers[layer_number - 1].classList.remove('not-visibile');
				}
			}

			button.addEventListener('mouseover', e => {
				var img     = e.target.childNodes[1],
					img_src = img.getAttribute('src');

				if (img_src == '/imgs/visibility.png') {
					informationAboutFunction.innerHTML = 'Убрать';
				}else{
					informationAboutFunction.innerHTML = 'Показать';
				}
			})

			button.addEventListener('mouseout', e => {
				informationAboutFunction.innerHTML = '';
			})
		})
	}catch{

	}

	fill_buttons.forEach(button => {
		button.addEventListener('mouseover', e => {
			if (isRow) {
				var layer_number        = e.target.parentNode.parentNode.parentNode.getAttribute('data-n'),
					grid_fill_container = document.querySelector('.grid_fill_row_container');
				
				grid_fill_container.style.display = 'block';
				grid_fill_container.style.top = 50*(layer_number - 1) + 'px';
			}else {
				var column_number        = e.target.parentNode.parentNode.parentNode.getAttribute('data-n'),
					grid_fill_container  = document.querySelector('.grid_fill_column_container');

				grid_fill_container.style.display = 'block';
				grid_fill_container.style.left = (column_number - 1)*100/numberOfColumns + '%';
				grid_fill_container.style.width = 100/numberOfColumns + '%';
			}
			informationAboutFunction.innerHTML = 'Подсветить';
		})

		button.addEventListener('mouseout', e => {
			if (isRow) {
				var grid_fill_container = document.querySelector('.grid_fill_row_container');
			}else{
				var grid_fill_container = document.querySelector('.grid_fill_column_container');
			}
			
			grid_fill_container.style.display = 'none';
			informationAboutFunction.innerHTML = '';
		})
	})

	try{
		delete_buttons.forEach(button => {
			var table              = document.querySelector('.grid table tbody'),
				main_section       = document.querySelector('.main_section');

			button.onclick = e => {
				if (isRow) {
					var grid_dropdown_list = document.querySelector('.dropdow_list_row .all_information');
					var row = table.childNodes[table.childNodes.length - 1];
					var list_row = grid_dropdown_list.childNodes[grid_dropdown_list.childNodes.length - 3];
					table.removeChild(row);
					grid_dropdown_list.removeChild(list_row);
					main_section.style.height = parseFloat(main_section.offsetHeight) - 100 + 'px';	
				}else{
					var grid_dropdown_list = document.querySelector('.dropdow_list_column .all_information');
					var list_row = grid_dropdown_list.childNodes[grid_dropdown_list.childNodes.length - 3];
					for (var elem of table.childNodes) {
						try{
							elem.removeChild(elem.childNodes[elem.childNodes.length - 1]);
						}catch{

						}	
					}

					numberOfColumns--;
					root.style.setProperty('--number-of-columns', numberOfColumns);

					grid_dropdown_list.removeChild(list_row);
				}
				
			}

			button.addEventListener('mouseover', e => {
				informationAboutFunction.innerHTML = 'Удалить';			
			})

			button.addEventListener('mouseout', e => {
				informationAboutFunction.innerHTML = '';
			})
		})
	}catch{

	}
}












var dropdown_list_buttons = document.querySelectorAll('.dropdown_list .color');

dropdown_list_buttons.forEach(button => {
	button.onclick = e => {
		if (e.target.classList.contains('color')) {
			var arrow = e.target.childNodes[1];
			e.target.classList.toggle('active');
			if (arrow.innerHTML != '▲'){
				arrow.innerHTML = '▲';
			}else{
				arrow.innerHTML = '&#9660';
			}
		}else{
			var target = e.target.parentNode,
				arrow = e.target;
			target.classList.toggle('active');
			if (arrow.innerHTML != '▲'){
				arrow.innerHTML = '▲';
			}else{
				arrow.innerHTML = '&#9660';
			}
		}
	}
})

var grid_row_visibility_buttons    = document.querySelectorAll('.grid_row .visiblity'),
	grid_row_fill_buttons          = document.querySelectorAll('.grid_row .fill_row'),
	grid_row_delete_buttons        = document.querySelectorAll('.grid_row .delete_row'),
	grid_column_fill_buttons       = document.querySelectorAll('.grid_column .fill_column'),
	grid_column_delete_buttons     = document.querySelectorAll('.grid_column .delete_column'),
	informationAboutFunctionRow    = document.querySelector('.function_name_row'),
	informationAboutFunctionColumn = document.querySelector('.function_name_column');


this.addEventListener('mouseup', e => {
	isMouseDown = false;

	if (isGridSticky&&isUserCanSelect&&isCursorExitMainBlock&&isUserClickToSelect) {
		correctStickySelectionBlock(lastTimeClickedBlock);

		if (isUserSelectText) {
			makeOneGlobalObjectActive(dropdown_list_about_font_size);
		}else if(isUserSelectRectangle) {
			makeOneGlobalObjectActive(choose_background_of_rectangle_block);
		}
	}
	
	isUserClickToSelect = false;
})

this.addEventListener('keydown', e => {
	if (e.keyCode == 16) {
		isShiftDown = true;
	}
})

this.addEventListener('keyup', e => {
	if (e.keyCode == 16) {
		isShiftDown = false;
	}
})




onButtonClick(true, grid_row_visibility_buttons, grid_row_fill_buttons, null, informationAboutFunctionRow);
onButtonClick(false, null, grid_column_fill_buttons, null, informationAboutFunctionColumn);

var button_add_row    = document.querySelector('.add_row .button_color');
var button_add_column = document.querySelector('.add_column .button_color');

add_text_button.onclick = () => {
	if (!text_about_how_add_text.classList.contains('active')) {
		block_for_selection.style.left = '0%';
		block_for_selection.style.top = '0px';
		block_for_selection.style.width = '0%';
		block_for_selection.style.height ='0px';
		block_for_selection.style.display = 'none';

		makeOneGlobalObjectActive(text_about_how_add_text);
		isUserCanSelectHorizontal = false;
		isUserCanSelect = true;
		isUserSelectText = true;
		isUserSelectRectangle = false;
		isUserSelectHeader = false;
	}
}

add_header_button.onclick = () => {
	if (!text_about_how_add_header.classList.contains('active')) {
		block_for_selection.style.left = '0%';
		block_for_selection.style.top = '0px';
		block_for_selection.style.width = '0%';
		block_for_selection.style.height ='0px';
		block_for_selection.style.display = 'none';

		makeOneGlobalObjectActive(text_about_how_add_header);
		isUserCanSelectHorizontal = true;
		isUserCanSelect = false;
		isUserSelectText = false;
		isUserSelectRectangle = false;
		isUserSelectHeader = true;
	}
}

add_rectangle_button.onclick = () => {
	if (!text_about_how_add_rectangle.classList.contains('active')) {
		block_for_selection.style.left = '0%';
		block_for_selection.style.top = '0px';
		block_for_selection.style.width = '0%';
		block_for_selection.style.height ='0px';
		block_for_selection.style.display = 'none';

		makeOneGlobalObjectActive(text_about_how_add_rectangle);
		isUserCanSelectHorizontal = false;
		isUserCanSelect = true;
		isUserSelectText = false;
		isUserSelectRectangle = true;
		isUserSelectHeader = false;
	}
}

var main_section        = document.querySelector('.main_section_container_for_objects'),
	block_for_selection = document.querySelector('.selection_block');

var firstPosX             = 0,
	firstPosY             = 0;

all_font_size_dropdown_list_items.forEach(item => {
	item.onclick = e => {
		clear_all(all_font_size_dropdown_list_items);

		e.target.classList.add('active');
		if (!choose_font_size_button_block.classList.contains('active')) {
			choose_font_size_button_block.classList.add('active');
		}
	}
})

all_font_color_dropdown_list_items.forEach(item => {
	item.onclick = e => {
		clear_all(all_font_color_dropdown_list_items);

		e.target.classList.add('active');
		if (!choose_font_color_button_block.classList.contains('active')) {
			choose_font_color_button_block.classList.add('active');
		}
	}
})

all_header_size_dropdown_list_items.forEach(item => {
	item.onclick = e => {
		clear_all(all_header_size_dropdown_list_items);

		e.target.classList.add('active');

		if (!choose_header_size_button_block.classList.contains('active')) {
			choose_header_size_button_block.classList.add('active');
			choose_header_size_button_block.style.display = 'block';
		}
	}
})

all_header_color_dropdown_list_items.forEach(item => {
	item.onclick = e => {
		clear_all(all_header_color_dropdown_list_items);

		e.target.classList.add('active');
		if (!choose_header_color_button_block.classList.contains('active')) {
			choose_header_color_button_block.classList.add('active');
		}
	}
})

var save_font_size    = null,
	save_font_color   = null,
	save_header_size  = null,
	save_header_color = null,
	main_container    = document.querySelector('.main_section_container_for_objects');

main_container.innerHTML = mainContent;
save_container_content();

function save_textarea(container, font_size, font_color){
	var textarea = document.createElement('textarea'),
		textareaPosX   = block_for_selection.offsetLeft,
		textareaPosY   = block_for_selection.offsetTop,
		textareaWidth  = block_for_selection.offsetWidth,
		textareaHeight = block_for_selection.offsetHeight,
		max_width      = container.offsetWidth;

	textareaPosX = 100*textareaPosX/max_width;
	textareaWidth = 100*textareaWidth/max_width;

	textarea.classList.add('user_text');
	textarea.classList.add('userClickNode');
	textarea.classList.add('fs' + font_size);
	textarea.classList.add('color-' + font_color);

	textarea.setAttribute('style', `
		left: ${textareaPosX}%;
		top: ${textareaPosY}px;
		width: ${textareaWidth}%;
		height: ${textareaHeight}px;
	`);
	textarea.setAttribute('autofocus', '');
	textarea.setAttribute('data-type', 'textarea');
	textarea.setAttribute('placeholder', 'Введите текст');

	container.append(textarea);

	isUserCanSelect = false;
	makeOneGlobalObjectActive(null);
	block_for_selection.style.display = 'none';
	isUserHasChanges = true;
	update_nodes();

	save_container_content();

	update_textareas();
}

function save_header(container, font_size, font_color){
	var input          = document.createElement('input'),
		inputPosX      = block_for_selection.offsetLeft,
		inputPosY      = block_for_selection.offsetTop,
		inputWidth     = block_for_selection.offsetWidth,
		max_width      = container.offsetWidth;

	inputPosX = 100*inputPosX/max_width;
	inputWidth = 100*inputWidth/max_width;

	input.classList.add('user_header');
	input.classList.add('userClickNode');
	input.classList.add('fs' + font_size);
	input.classList.add('color-' + font_color);

	input.setAttribute('style', `
		left: ${inputPosX}%;
		top: ${inputPosY}px;
		width: ${inputWidth}%;
	`);
	input.setAttribute('autofocus', '');
	input.setAttribute('data-type', 'header');
	input.setAttribute('placeholder', 'Введите текст');

	container.append(input);

	isUserCanSelectHorizontal = false;
	makeOneGlobalObjectActive(null);
	block_for_selection.style.display = 'none';
	isUserHasChanges = true;
	update_nodes();

	save_container_content();

	update_inputs();
}

function save_rectangle(container, background){
	var rectangle       = document.createElement('div'),
		rectanglePosX   = block_for_selection.offsetLeft,
		rectanglePosY   = block_for_selection.offsetTop,
		rectangleWidth  = block_for_selection.offsetWidth,
		rectangleHeight = block_for_selection.offsetHeight,
		max_width       = container.offsetWidth;

	rectanglePosX = 100*rectanglePosX/max_width;
	rectangleWidth = 100*rectangleWidth/max_width;

	rectangle.classList.add('rectangle');
	rectangle.classList.add('userClickNode');

	rectangle.setAttribute('style', `
		left: ${rectanglePosX}%;
		top: ${rectanglePosY}px;
		width: ${rectangleWidth}%;
		height: ${rectangleHeight}px;
		background: ${background};
	`);
	rectangle.setAttribute('data-type', 'rectangle');

	container.append(rectangle);

	isUserCanSelect = false;
	makeOneGlobalObjectActive(null);
	block_for_selection.style.display = 'none';
	isUserHasChanges = true;
	update_nodes();

	save_container_content();
}

choose_font_size_button.onclick = () => {
	var user_choice = document.querySelector('.font_size_settings .dropdown_list_choice.active'),
		font_size   = user_choice.getAttribute('data-size');


	makeOneGlobalObjectActive(dropdown_list_about_font_color);

	save_font_size = font_size;
}

choose_font_color_button.onclick = () => {
	var user_choice = document.querySelector('.font_color_settings .dropdown_list_choice.active'),
		font_color   = user_choice.getAttribute('data-color');


	makeOneGlobalObjectActive(null);

	save_font_color = font_color;

	save_textarea(selectionBlockParent, save_font_size, save_font_color);
}

choose_header_size_button.onclick = () => {
	var user_choice = document.querySelector('.header_size_settings .dropdown_list_choice.active'),
		font_size   = user_choice.getAttribute('data-size');


	makeOneGlobalObjectActive(dropdown_list_about_header_color);

	save_header_size = font_size;
}

choose_header_color_button.onclick = () => {
	var user_choice = document.querySelector('.header_color_settings .dropdown_list_choice.active'),
		font_color   = user_choice.getAttribute('data-color');


	makeOneGlobalObjectActive(null);

	save_header_color = font_color;

	save_header(selectionBlockParent, save_header_size, save_header_color);
}

choose_background_of_rectangle_button.onclick = () => {
	var background_button = document.querySelector('.choose_background_of_rectangle_block input[type=color]'),
		background_color  = background_button.value;


	save_rectangle(selectionBlockParent, background_color);
}





function save_container_content(){
	var containerContent = document.querySelector('.main_section_container_for_objects').innerHTML;

	document.querySelector('textarea.formContent').value = containerContent;
}

function update_inputs(){
	var inputs = document.querySelectorAll('.user_header');

	inputs.forEach(input => {
		input.onchange = () => {
			input.setAttribute('data-value', input.value);

			save_container_content();
		}
	})
}

function update_textareas(){
	var textareas = document.querySelectorAll('.user_text');

	textareas.forEach(textarea => {
		textarea.onchange = () => {
			textarea.setAttribute('data-value', textarea.value);

			save_container_content();
		}
	})
}





var userClickNodes                    = document.querySelectorAll('.userClickNode'),
	informationInputs                 = document.querySelectorAll('.input_number'),
	block_for_information_about_block = document.querySelector('.main_information_about_block');

update_nodes();
console.log(userClickNodes);

function rgb2hex(rgbText) {
    var rgb = rgbText.match(/^rgb?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);

    if (!rgb) {
    	rgb = rgbText.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
    }

    return (rgb) ? "#" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
};

function update_nodes(){
	userClickNodes    = document.querySelectorAll('.userClickNode');

	userClickNodes.forEach(node => {
		node.onclick = e => {
			if (!block_for_information_about_block.classList.contains('active')) {
				block_for_information_about_block.classList.add('active');
			}

			showInformation_about_node(e.target);

			informationInputs = document.querySelectorAll('.input_number');

			informationInputs.forEach(node => {
				correct_input(node, node.classList[1].split('_')[1], e.target);
			})
		}
	})
}

function hideAllInputs(){
	var inputs = document.querySelectorAll('.main_information_about_block__list li.inActiveBlock')
	clear_all(inputs);
}

function showInformation_about_node(node){
	var type   = document.querySelector('span.node_type'),
		width  = document.querySelector('span.node_width'),
		height = document.querySelector('span.node_height'),
		posX   = document.querySelector('span.node_pos_X'),
		posY   = document.querySelector('span.node_pos_Y');

	var isNodeHasFontStyles = true,
		nodeFontSize        = 0,
		nodeFontColor       = '';

	try{
		nodeFontSize  = parseFloat(getComputedStyle(node).fontSize);
		nodeFontColor = parseFloat(getComputedStyle(node).color);
	}catch(e){
		isNodeHasFontStyles = false;
	}

	hideAllInputs();

	type.innerHTML   = node.getAttribute('data-type');

	width.innerHTML  = `<input class='input_number input_width' type='number' 
						max=${main_section.offsetWidth - node.offsetLeft} 
						min=0 value=${node.offsetWidth}
						data-main_property='offsetWidth' data-node_property='offsetLeft'> px`;

	height.innerHTML = `<input class='input_number input_height' type='number' 
						max=${main_section.offsetHeight - node.offsetTop} 
						min=0 value=${node.offsetHeight}
						data-main_property='offsetHeight' data-node_property='offsetTop'> px`;

	posX.innerHTML   = `<input class='input_number input_left' type='number' 
						max=${main_section.offsetWidth - node.offsetWidth} 
						min=0 value=${node.offsetLeft}
						data-main_property='offsetWidth' data-node_property='offsetWidth'> px`;

	posY.innerHTML   = `<input class='input_number input_top' type='number' 
						max=${main_section.offsetHeight - node.offsetHeight} 
						min=0 value=${node.offsetTop}
						data-main_property='offsetHeight' data-node_property='offsetHeight'> px`;

	if (isNodeHasFontStyles) {
		height.childNodes[0].setAttribute('min', nodeFontSize);
	}

	var suitableInputsBlocksForThisNode = document.querySelectorAll(`.main_information_about_block__list li.node_${node.getAttribute('data-type')}`);

	suitableInputsBlocksForThisNode.forEach(inputBlock => {
		inputBlock.classList.add('active');

		var span_class    = inputBlock.getAttribute('data-span_container'),
			span          = document.querySelector(`span.${span_class}`),
			node_styles   = getComputedStyle(node),
			span_property = span.classList[0].split('_')[1],
			input_type    = inputBlock.getAttribute('data-span_type');

		if (input_type == 'color') {
			var input_value   = rgb2hex(node_styles[span_property]);

			if(span_property == 'color'){

				var isTrue  = {
					'is-color-black'     : '',
					'is-color-dark-grey' : '',
					'is-color-grey'      : '',
					'is-color-white'     : '',
					'is-color-orange'    : ''
				},
					bgClass = '';

				isTrue[`is-${node.classList[3]}`] = 'selected';

				if (isTrue['is-color-white'] != '') {
					bgClass = 'background-grey';
				}

				span.innerHTML = `
				<select value='${input_value}' class='changeableSelect ${node.classList[3]} ${bgClass}' data-property='color'>
					<option style='background: white;' class='color-black bold' ${isTrue['is-color-black']}>#000000</option>
					<option style='background: white;' class='color-dark-grey bold' ${isTrue['is-color-dark-grey']}>#696969</option>
					<option style='background: white;' class='color-grey bold' ${isTrue['is-color-grey']}>#a9a9a9</option>
					<option class='color-white background-grey bold' ${isTrue['is-color-white']}>#ffffff</option>
					<option style='background: white;' class='color-orange bold' ${isTrue['is-color-orange']}>#ffa500</option>
				</select>
				`;
			}else if(span_property == 'backgroundColor'){
				span.innerHTML = `<input class='input_${span_property}' type='${input_type}'
								value='${input_value}'>`;

				span.childNodes[0].oninput = () => {
					node.style.background = span.childNodes[0].value;
				}
			}
		}else if(input_type == 'text'){
			var input_value   = node_styles[span_property];

			if (span_property == 'fontSize') {
				var isTrue = {
					'12px' : '',
					'14px' : '',
					'18px' : '',
					'24px' : '',
					'28px' : '',
					'32px' : ''
				};

				isTrue[input_value] = 'selected';

				span.innerHTML = `
				<select class='changeableSelect' data-property='fontSize'>
					<option class='bold' ${isTrue['12px']}>12px</option>
					<option class='bold' ${isTrue['14px']}>14px</option>
					<option class='bold' ${isTrue['18px']}>18px</option>
					<option class='bold' ${isTrue['24px']}>24px</option>
					<option class='bold' ${isTrue['28px']}>28px</option>
					<option class='bold' ${isTrue['32px']}>32px</option>
				</select>
				`;
			}else if(span_property == 'borderRadius'){
				var input_value   = parseFloat(node_styles[span_property]);

				span.innerHTML = `<input class='input_number input_borderRadius' type='number' 
						max=100 min=0 value=${input_value}> px`;
			}
		}
	})

	corectInformationOnChangeSelect(node);
}

function correct_input(input, property, node){
	input.addEventListener('keydown', e => {
		if (e.keyCode != 8) {
			if (48 > e.keyCode) {
				e.preventDefault();
			}else if(e.keyCode > 57){
				e.preventDefault();
			}else if (parseFloat(`${input.value}${String.fromCharCode(e.keyCode)}`) > parseFloat(input.getAttribute('max'))) {
				input.value = parseFloat(input.getAttribute('max'));
				node.style[`${property}`] = input.value + 'px';
				if (property != 'borderRadius') {
					correct_maximum_of_input(node);
				}
				e.preventDefault();
			}
		}
	})

	input.addEventListener('keyup', e => {
		if (parseFloat(input.value) > parseFloat(input.getAttribute('max'))) {
			input.value = input.getAttribute('max');
		}
	})

	input.addEventListener('input', e => {
		node.style[`${property}`] = input.value + 'px';
		if (property != 'borderRadius') {
			correct_maximum_of_input(node);
		}
	})
}

function correct_maximum_of_input(node){
	informationInputs.forEach(input => {
		input.max = main_section[`${input.getAttribute('data-main_property')}`] 
					- node[`${input.getAttribute('data-node_property')}`];
	})
}

function corectInformationOnChangeSelect(node){
	var selects = document.querySelectorAll('select.changeableSelect');

	selects.forEach(select => {
		select.onchange = e => {
			var property = select.getAttribute('data-property');

			if (property == 'color') {
				var newFontColor = e.target.value;

				var nodeClasses = node.className.split(' ');
				nodeClasses[3] = `color-${fontColors[newFontColor]}`;
				node.className = nodeClasses.join(' ');

				var selectClasses = select.className.split(' ');
				selectClasses[1] = `color-${fontColors[newFontColor]}`;
				select.className = selectClasses.join(' ');

				if (fontColors[newFontColor] == 'white') {
					select.classList.add('background-grey');
				}else{
					if (select.classList.contains('background-grey')) {
						select.classList.remove('background-grey');
					}
				}
			}else if(property == 'fontSize'){
				var newFontSize = parseFloat(e.target.value);

				var nodeClasses = node.className.split(' ');
				nodeClasses[2] = `fs${newFontSize}`;
				node.className = nodeClasses.join(' ');
			}
		}
		
	})
}





