function exportPDF(filename, title_id, sub_title_id = "") {
	var doc = new jsPDF("p", "pt");
	doc.setFont("Sarabun-Medium");
	doc.setFontType("normal");
	doc.setFontSize(10);

	var text = $("#" + title_id).text();
	xOffset =
		doc.internal.pageSize.width / 2 -
		(doc.getStringUnitWidth(text) * doc.internal.getFontSize()) / 2;
	doc.text(text, xOffset, 30);
	xOffset =
		doc.internal.pageSize.width / 2 -
		(doc.getStringUnitWidth(sub_title_id) * doc.internal.getFontSize()) / 2;
	doc.text(sub_title_id, xOffset, 50);

	doc.autoTable({
		html: "#table-list",
		startY: 80,
		theme: "grid",
		headStyles: {
			font: "Sarabun-Bold",
			fontStyle: "bold",
			valign: "middle",
			// lineColor: 2,
			// lineWidth: 1,
			halign: "center",
		},
		styles: {
			font: "Sarabun-Medium",
			fontSize: 8,
			// margin: {left: 5,right: 5},
			// fillColor: [255, 0, 0],
			overflow: "normal",
			// halign: "center",
			overflow: "linebreak",
			cellWidth: "wrap",
		},
		footStyles: {
			font: "Sarabun-Bold",
			fontStyle: "bold",
			valign: "middle",
		},
		margin: { left: 10, right: 10 },
		pageBreak: "auto",
		showFoot: "lastPage",
	});
	doc.save(filename);
}

function exportPDF_multi(filename, sub_title = "") {
	var doc = new jsPDF("p", "pt");
	doc.setFont("Sarabun-Medium");
	doc.setFontType("normal");
	$.each(sub_title, function (i, value) {
		doc.setFontSize(10);
		xOffset =
			doc.internal.pageSize.width / 2 -
			(doc.getStringUnitWidth(value) * doc.internal.getFontSize()) / 2;
		doc.text(value, xOffset, 20 * (i + 1));
	});
	doc.autoTable({
		html: "#table-list",
		startY: 80,
		theme: "grid",
		headStyles: {
			font: "Sarabun-Bold",
			fontStyle: "bold",
			valign: "middle",
			// lineColor: 2,
			// lineWidth: 1
		},
		styles: {
			font: "Sarabun-Medium",
			fontSize: 8,
			// margin: {left: 5,right: 5},
			// fillColor: [255, 0, 0],
			overflow: "normal",
			halign: "center",
		},
		footStyles: {
			font: "Sarabun-Bold",
			fontStyle: "bold",
			valign: "middle",
		},
		margin: { left: 10, right: 10 },
		pageBreak: "auto",
		showFoot: "lastPage",
	});
	doc.save(filename);
}

function exportPDFSum(filename, title_id, sub_title_id = "") {
	var doc = new jsPDF("p", "pt");
	doc.setFont("Sarabun-Medium");
	doc.setFontType("normal");
	doc.setFontSize(10);

	var text = $("#" + title_id).text();
	xOffset =
		doc.internal.pageSize.width / 2 -
		(doc.getStringUnitWidth(text) * doc.internal.getFontSize()) / 2;
	doc.text(text, xOffset, 30);
	xOffset =
		doc.internal.pageSize.width / 2 -
		(doc.getStringUnitWidth(sub_title_id) * doc.internal.getFontSize()) / 2;
	doc.text(sub_title_id, xOffset, 50);

	doc.autoTable({
		html: "#table-list",
		startY: 80,
		theme: "grid",
		headStyles: {
			font: "Sarabun-Bold",
			fontStyle: "bold",
			valign: "middle",
			// lineColor: 2,
			// lineWidth: 1,
			halign: "center",
		},
		styles: {
			font: "Sarabun-Medium",
			fontSize: 8,
			// margin: {left: 5,right: 5},
			// fillColor: [255, 0, 0],
			overflow: "normal",
			// halign: "center",
			overflow: "linebreak",
			cellWidth: "wrap",
		},
		footStyles: {
			font: "Sarabun-Bold",
			fontStyle: "bold",
			valign: "middle",
		},
		margin: { left: 10, right: 10 },
		pageBreak: "auto",
		showFoot: "lastPage",
	});
	doc.save(filename);
}
