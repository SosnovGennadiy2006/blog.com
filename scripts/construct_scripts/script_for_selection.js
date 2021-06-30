function allow_block_to_be_selected(block){
	block.addEventListener('mousedown', e => {
		isMouseDown = true;
		isUserClickToSelect = true;
		lastTimeClickedBlock = block;
		selectionBlockParent = block;
		if (isUserCanSelect) {
			block_for_selection.style.display = 'block';
			firstPosX = e.offsetX + e.target.offsetLeft;
			firstPosY = e.offsetY + e.target.offsetTop;

			block_for_selection.style.left = firstPosX + 'px';
			block_for_selection.style.top = firstPosY + 'px';
			block_for_selection.style.width = 0 + 'px';
			block_for_selection.style.height = 0 + 'px';
		}
	})

	block.addEventListener('mouseout', e => {
		isCursorExitMainBlock = true;
	})

	block.addEventListener('mouseover', e => {
		isCursorExitMainBlock = false;
	})

	block.addEventListener('mousemove', e => {
		var main_width  = block.offsetWidth,
			main_height = block.offsetHeight;

		if (!isShiftDown&&isUserCanSelect&&isMouseDown) {
			if (e.offsetX + e.target.offsetLeft > firstPosX) {
				block_width = e.offsetX - firstPosX + e.target.offsetLeft;
				newPosX = firstPosX;
			}else{
				block_width = firstPosX - e.offsetX - e.target.offsetLeft;
				newPosX = e.offsetX + e.target.offsetLeft;
			}

			if (e.offsetY + e.target.offsetTop > firstPosY) {
				block_height = e.offsetY - firstPosY + e.target.offsetTop;
				newPosY = firstPosY;
			}else{
				block_height = firstPosY - e.offsetY - e.target.offsetTop;
				newPosY = e.offsetY + e.target.offsetTop;
			}

			newPosX  = newPosX*100/main_width;
			block_width = block_width*100/main_width;

			block_for_selection.style.left = newPosX + '%';
			block_for_selection.style.top = newPosY + 'px';
			block_for_selection.style.width = block_width + '%';
			block_for_selection.style.height = block_height + 'px';
		}else if (isShiftDown&&isUserCanSelect&&isMouseDown) {
			if (e.offsetX + e.target.offsetLeft > firstPosX) {
				block_width = e.offsetX - firstPosX + e.target.offsetLeft;
				newPosX = firstPosX;
			}else{
				block_width = firstPosX - e.offsetX - e.target.offsetLeft;
				newPosX = e.offsetX + e.target.offsetLeft;
			}

			if (e.offsetY + e.target.offsetTop > firstPosY) {
				block_height = e.offsetY - firstPosY + e.target.offsetTop;
				newPosY = firstPosY;
			}else{
				block_height = firstPosY - e.offsetY - e.target.offsetTop;
				newPosY = e.offsetY + e.target.offsetTop;
			}

			if (block_width > block_height) {
				if (newPosY + block_width < main_height) {
					block_height = block_width;
				}else{
					block_height = main_height - newPosY;
				}
			}else{
				if (newPosX + block_height < main_width) {
					block_width = block_height;
				}else{
					block_width = main_width - newPosX;
				}
			}

			newPosX  = newPosX*100/main_width;
			block_width = block_width*100/main_width;

			block_for_selection.style.left = newPosX + '%';
			block_for_selection.style.top = newPosY + 'px';
			block_for_selection.style.width = block_width + '%';
			block_for_selection.style.height = block_height + 'px';
		}
	})

	block.addEventListener('mouseup', e => {
		if (isGridSticky&&isUserCanSelect) {
			correctStickySelectionBlock(block);
			if (isUserSelectText) {
				makeOneGlobalObjectActive(dropdown_list_about_font_size);
			}else if(isUserSelectRectangle) {
				makeOneGlobalObjectActive(choose_background_of_rectangle_block);
			}
		}else if(isUserCanSelect){
			if (isUserSelectText) {
				makeOneGlobalObjectActive(dropdown_list_about_font_size);
			}else if(isUserSelectRectangle) {
				makeOneGlobalObjectActive(choose_background_of_rectangle_block);
			}
		}
	})
}

function allow_block_to_be_selected_by_horizontal(block){
	block.addEventListener('mousedown', e => {
		isMouseDown = true;
		isUserClickToSelect = true;
		lastTimeClickedBlock = block;
		selectionBlockParent = block;
		if (isUserCanSelectHorizontal) {
			block_for_selection.style.display = 'block';
			firstPosX = e.offsetX + e.target.offsetLeft;
			firstPosY = e.offsetY + e.target.offsetTop;

			block_for_selection.style.left = firstPosX + 'px';
			block_for_selection.style.top = firstPosY + 'px';
			block_for_selection.style.width = 0 + 'px';
			block_for_selection.style.height = 30 + 'px';
		}
	})

	block.addEventListener('mouseout', e => {
		isCursorExitMainBlock = true;
	})

	block.addEventListener('mouseover', e => {
		isCursorExitMainBlock = false;
	})

	block.addEventListener('mousemove', e => {
		var main_width  = block.offsetWidth,
			main_height = block.offsetHeight;

		if (!isShiftDown&&isUserCanSelectHorizontal&&isMouseDown) {
			if (e.offsetX + e.target.offsetLeft > firstPosX) {
				block_width = e.offsetX - firstPosX + e.target.offsetLeft;
				newPosX = firstPosX;
			}else{
				block_width = firstPosX - e.offsetX - e.target.offsetLeft;
				newPosX = e.offsetX + e.target.offsetLeft;
			}

			newPosX  = newPosX*100/main_width;
			block_width = block_width*100/main_width;

			block_for_selection.style.left = newPosX + '%';
			block_for_selection.style.width = block_width + '%';
		}else if (isShiftDown&&isUserCanSelectHorizontal&&isMouseDown) {
			if (e.offsetX + e.target.offsetLeft > firstPosX) {
				block_width = e.offsetX - firstPosX + e.target.offsetLeft;
				newPosX = firstPosX;

				if (newPosX - block_width > 0) {
					newPosX -= block_width;
					block_width += block_width;
				}else{
					newPosX = 0;
					block_width += firstPosX;
				}
			}else{
				block_width = firstPosX - e.offsetX - e.target.offsetLeft;
				newPosX = e.offsetX + e.target.offsetLeft;

				if (newPosX + 2*block_width < main_width) {
					block_width += block_width;
				}else{
					block_width = main_width - newPosX;
				}
			}

			newPosX  = newPosX*100/main_width;
			block_width = block_width*100/main_width;

			block_for_selection.style.left = newPosX + '%';
			block_for_selection.style.width = block_width + '%';
		}
	})

	block.addEventListener('mouseup', e => {
		if (isGridSticky&&isUserCanSelectHorizontal) {
			correctStickySelectionBlockByHorizontal(block);
			if (isUserSelectHeader) {
				makeOneGlobalObjectActive(dropdown_list_about_header_size);
			}
		}else if(isUserCanSelectHorizontal){
			if (isUserSelectHeader) {
				makeOneGlobalObjectActive(dropdown_list_about_header_size);
			}
		}
	})
}


function correctStickySelectionBlock(block){
	var blockPosX   = parseFloat(block_for_selection.offsetLeft),
		blockPosY   = parseFloat(block_for_selection.offsetTop),
		blockWidth  = parseFloat(block_for_selection.offsetWidth),
		blockHeight = parseFloat(block_for_selection.offsetHeight),
		main_width  = parseFloat(block.offsetWidth),
		main_height = parseFloat(block.offsetHeight);

	blockWidth = blockWidth - (blockPosX + blockWidth)%(main_width/numberOfColumns) + main_width/numberOfColumns + blockPosX%(main_width/numberOfColumns);
	blockHeight = blockHeight - (blockPosY + blockHeight)%50 + 50 + blockPosY%50;
	blockPosY = blockPosY - blockPosY%50;
	blockPosX = blockPosX - blockPosX%(main_width/numberOfColumns);

	if (blockPosX + blockWidth > main_width) {
		blockWidth = main_width - blockPosX;
	}

	if (blockPosY + blockHeight > main_height) {
		blockHeight = main_height - blockPosY;
	}

	blockPosX  = blockPosX*100/main_width;
	blockWidth = blockWidth*100/main_width;

	block_for_selection.style.left = blockPosX + '%';
	block_for_selection.style.top = blockPosY + 'px';
	block_for_selection.style.width = blockWidth + '%';
	block_for_selection.style.height = blockHeight + 'px';
}

function correctStickySelectionBlockByHorizontal(block){
	var blockPosX   = parseFloat(block_for_selection.offsetLeft),
		blockWidth  = parseFloat(block_for_selection.offsetWidth),
		main_width  = parseFloat(block.offsetWidth),
		main_height = parseFloat(block.offsetHeight);

	blockWidth = blockWidth - (blockPosX + blockWidth)%(main_width/numberOfColumns) + main_width/numberOfColumns + blockPosX%(main_width/numberOfColumns);
	blockPosX = blockPosX - blockPosX%(main_width/numberOfColumns);

	if (blockPosX + blockWidth > main_width) {
		blockWidth = main_width - blockPosX;
	}

	blockPosX  = blockPosX*100/main_width;
	blockWidth = blockWidth*100/main_width;

	block_for_selection.style.left = blockPosX + '%';
	block_for_selection.style.width = blockWidth + '%';
}