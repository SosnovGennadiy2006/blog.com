button_add_row.onclick = e => {
	var table        = document.querySelector('.grid table tbody'),
		table_rows   = document.querySelectorAll('.grid table tr'),
		numberOfRows = table_rows.length,
		main_section = document.querySelector('.main_section');

	var new_row = document.createElement('tr');
	new_row.setAttribute('data-n', numberOfRows);
	new_row.innerHTML = "<th></th>".repeat(numberOfColumns);

	table.append(new_row);
	main_section.style.height = parseFloat(main_section.offsetHeight) + 50 + 'px';

	var function_row          = document.createElement('li'),
		save_button_container = document.querySelector('.add_row');

	function_row.setAttribute('data-n', numberOfRows + 1);
	function_row.classList.add('grid_row');
	function_row.innerHTML = `<div class="flex_line">
									<div class="number">${numberOfRows + 1}</div>
									<div class="functions">
										<div class="visiblity function_button">
											<img src="/imgs/visibility.png">
										</div>
										<div class="fill_row function_button">
											<img src="/imgs/fill.png">
										</div>
										<div class="delete_row function_button">
											<img src="/imgs/trash.png">
										</div>
									</div>
								</div>`;

	save_button_container.before(function_row);

	var grid_visibility_buttons = document.querySelectorAll('.grid_row .visiblity'),
		grid_fill_buttons       = document.querySelectorAll('.grid_row .fill_row'),
		grid_delete_buttons     = document.querySelectorAll('.grid_row .delete_row');

	isUserCanSelect = false;
	makeOneGlobalObjectActive(null);
	block_for_selection.style.display = 'none';
	onButtonClick(true, grid_visibility_buttons, grid_fill_buttons, grid_delete_buttons, informationAboutFunctionRow);
}

button_add_column.onclick = e => {
	var table        = document.querySelector('.grid table tbody'),
		table_rows   = document.querySelectorAll('.grid table tr'),
		main_section = document.querySelector('.main_section');

	for (var elem of table_rows) {
		var new_column = document.createElement('th');
		elem.append(new_column);
	}

	numberOfColumns++;
	root.style.setProperty('--number-of-columns', numberOfColumns);

	var function_column          = document.createElement('li'),
		save_button_container = document.querySelector('.add_column');

	function_column.setAttribute('data-n', numberOfColumns);
	function_column.classList.add('grid_column');
	function_column.innerHTML = `<div class="flex_line">
									<div class="number">${numberOfColumns}</div>
									<div class="functions">
										<div class="fill_column function_button">
											<img src="/imgs/fill.png">
										</div>
										<div class="delete_column function_button">
											<img src="/imgs/trash.png">
										</div>
									</div>
								</div>`;

	save_button_container.before(function_column);

	var grid_fill_buttons       = document.querySelectorAll('.grid_column .fill_column'),
		grid_delete_buttons     = document.querySelectorAll('.grid_column .delete_column');

	isUserCanSelect = false;
	makeOneGlobalObjectActive(null);
	block_for_selection.style.display = 'none';
	onButtonClick(false, null, grid_fill_buttons, grid_delete_buttons, informationAboutFunctionColumn);
}