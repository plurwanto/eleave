
function setMail(param) 
{
	axios.post( apiUrl+'send-mail', param)
    .then((response) =>
    {
  		if(response.data.error)
  		{
  			return response.data.message
  		}
  		else
  		{
  			return `An email has been sent to ${param.to}`
  		}
    })
    .catch((response) =>
    {
      return 'Somethings wrong with the Application!<br/>Please contact your IT Team.'
    })
}

function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel, customFileName) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = customFileName;
    //this will remove the blank-spaces from the title and replace it with an underscore
    // fileName += ReportTitle.replace(/ /g,"_");
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function getMonthName(search)
{
    let month = [
                  {'name':'January'},
                  {'name':'February'},
                  {'name':'March'},
                  {'name':'April'},
                  {'name':'May'},
                  {'name':'June'},
                  {'name':'July'},
                  {'name':'August'},
                  {'name':'September'},
                  {'name':'October'},
                  {'name':'November'},
                  {'name':'Desember'}
    ]

    let monthName = month[search-1].name

    return monthName
}

function staffRequestNotif()
{
  // S:Get bubble notif for staff request
  $.ajax({
      url: `${apiUrl}eleave/staff-request/get-total-request`,
      type: 'POST',
      dataType: 'json',
      data: {token: token},
      beforeSend: function () {
        NProgress.start()
      },
      success: function (response) {
          if(response.response_code == 200)
          {
              if(response.data.total > 0)
              {
                  $(".nav-request-badge").text(response.data.total)
                  $(".nav-request-badge").attr('title', response.data.tooltip)
                  $(".nav-request-badge").removeClass('hidden')
              }
              else
              {
                  $(".nav-request-badge").text(0)
                  $(".nav-request-badge").attr('title', 'You do not have any request')
                  $(".nav-request-badge").addClass('hidden')
              }

              NProgress.done()
          }
          else
          {
              toastr.warning(`Failed to get total request`)
          }
      }
  })
  .fail(function() {
      toastr.error("System failure, Please contact the Administrator")
  })
  // E:Get bubble notif for staff request
}
