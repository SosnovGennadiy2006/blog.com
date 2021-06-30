var confirmOnPageExit = function (e) 
{
	if (isUserHasChanges) {
		e = e || window.event;

	    message = 'Вы уверены, что хотите закрыть эту страницу?\n\nВведённая вами информация может не сохраниться.';

	    if (e) 
	    {
	        e.returnValue = message;
	    }

	    return message;
	}
    
};

window.onbeforeunload = confirmOnPageExit;