$(document).ready(function() {
    //select all checkboxes
    $('input[name="select_all"]').change(function(){  //"select all" change 
        var status = this.checked; // "select all" checked status
        $('input[name="selected[]"]').each(function(){ //iterate all listed checkbox items
            this.checked = status; //change ".checkbox" checked status
        });
    });

    $('input[name="selected[]"]').change(function(){ //".checkbox" change 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(this.checked == false){ //if this item is unchecked
            $('input[name="select_all"]')[0].checked = false; //change "select all" checked status to false
        }

        //check "select all" if all checkbox items are checked
        if ($('input[name="selected[]"]:checked').length == $('input[name="selected[]"]').length ){ 
            $('input[name="select_all"]')[0].checked = true; //change "select all" checked status to true
        }
    });
});