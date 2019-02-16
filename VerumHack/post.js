function postinger(){
	var pass = true,
		message = "";

	// CHECKS
	if ($('#title').val() === "") {
		message += "Please enter your title." + "\n";
		pass = false;
	}
	if ($('#title').val().trim().length > 90) {
		message += "Please make sure your title is less than 90 characters." + "\n";
		pass = false;
	}
	if ($('#topic-category').val() === "") {
		message += "Please choose your topic." + "\n";
		pass = false;
	}
    if ($('#article').val().trim().length < 100) {
		message += "Please make sure your post is at least 100 characters" + "\n";
		pass = false;
	}
    if($("#human").is(':checked')){
	}
    else{
        message += "Please confirm your are a human." + "\n";
		pass = false;
    }
	if (pass) {
	    return true;
	} else {
		alert(message);
	}
	return false;
}
