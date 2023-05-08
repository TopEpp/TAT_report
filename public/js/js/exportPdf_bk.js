function exportPDF(filename,title_id,sub_title_id='',sc_month='',sc_year='',title_id2=''){
        var content1 = $('#content').text();
        var content2 = $('#content1').text();
        var content3 = $('#content2').text();
        var doc = new jsPDF('p', 'pt');
        doc.setFont('Sarabun-Medium');
        doc.setFontType('normal');
        doc.setFontSize(10);

        var text = $("#"+title_id).text();
        xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);
        doc.text(text, xOffset, 30);

        if(sub_title_id){
            if($( "#"+sub_title_id+" option:selected" ).text()!=''){
              var value = $( "#"+sub_title_id+" option:selected" ).text();
              var text = content1+' '+ value;
              xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);
              doc.text(text, xOffset, 50);
            }
        }

        if (sc_month) {
          if($( "#"+sc_month+" option:selected" ).text()!=''){
            var value1 = $( "#"+sc_month+" option:selected" ).text();
            if (sc_year) {
              var value2 = $( "#"+sc_year+" option:selected" ).text();
              var text = content2+' '+ value1+' '+content3+' '+ value2;
            }else {
              var text = content2+' '+ value1;
            }
            xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);
            doc.text(text, xOffset, 60);
          }
        }


        doc.autoTable({
            html: '#table-list',
            startY: 80,
            theme: 'grid',
            headStyles: {
                font: "Sarabun-Bold",
                fontStyle: 'bold',
                valign:'middle',
                // lineColor: 2,
                // lineWidth: 1,
                halign: "center"
               },
            styles: {

                font:'Sarabun-Medium',
                fontSize:8,
                // margin: {left: 5,right: 5},
                // fillColor: [255, 0, 0],
                overflow:'normal',
                // halign: "center",
                overflow: 'linebreak',
                cellWidth: 'wrap'
            },
            footStyles:{
                font: "Sarabun-Bold",
                fontStyle: 'bold',
                valign:'middle',
            },
            margin: {left: 10,right:10},
            pageBreak:'auto',
            showFoot:'lastPage'
        });
        doc.save(filename);

}

function exportPDF_2(filename,title_id,sub_title_id='',select_1=''){
        var content1 = $('#content').text();
        var content2 = $('#content1').text();
        var doc = new jsPDF('p', 'pt');
        doc.setFont('Sarabun-Medium');
        doc.setFontType('normal');
        doc.setFontSize(10);

        var text = $("#"+title_id).text();
        xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);
        doc.text(text, xOffset, 30);

        if(sub_title_id){
            if($( "#"+sub_title_id+" option:selected" ).text()!=''){
              var value = $( "#"+sub_title_id+" option:selected" ).text();
              var value2 = $("#"+select_1+" option:selected").text();
              var text = content1+' '+ value+' '+content2+' '+value2;
              xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);
              doc.text(text, xOffset, 50);
            }
        }
        doc.autoTable({
            html: '#table-list',
            startY: 80,
            theme: 'grid',
            headStyles: {
                font: "Sarabun-Bold",
                fontStyle: 'bold',
                valign:'middle',
                // lineColor: 2,
                // lineWidth: 1,
                halign: "center"
               },
            styles: {

                font:'Sarabun-Medium',
                fontSize:8,
                // margin: {left: 5,right: 5},
                // fillColor: [255, 0, 0],
                overflow:'normal',
                // halign: "center",
                overflow: 'linebreak',
                cellWidth: 'wrap'
            },
            footStyles:{
                font: "Sarabun-Bold",
                fontStyle: 'bold',
                valign:'middle',
            },
            margin: {left: 10,right:10},
            pageBreak:'auto',
            showFoot:'lastPage'
        });
        doc.save(filename);

}
