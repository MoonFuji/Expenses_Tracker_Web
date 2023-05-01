function editRow(button) {
			var row = button.parentNode.parentNode;
			var cells = row.getElementsByTagName("td");
			var name = cells[0].innerHTML;
			var date = cells[1].innerHTML;
			var category = cells[2].innerHTML;
			var amount = cells[3].innerHTML;
			cells[0].innerHTML = "<input type='text' value='" + name + "'>";
			cells[1].innerHTML = "<input type='date' value='" + date + "'>";
			cells[2].innerHTML = "<select><option value='Food'>Food</option><option value='Transportation'>Transportation</option></select>";
			cells[3].innerHTML = "<input type='number' value='" + amount.substring(1) + "'>";
			button.innerHTML = "Save";
			button.onclick = function() {
				cells[0].innerHTML = cells[0].firstChild.value;
				cells[1].innerHTML = cells[1].firstChild.value;
				cells[2].innerHTML = cells[2].firstChild.value;
				cells[3].innerHTML = "$" + cells[3].firstChild.value;
				button.innerHTML = "Edit";
				button.onclick = function() {editRow(button)};
			};
		}
	
function deleteRow(button) {
			var row = button.parentNode.parentNode;
			row.parentNode.removeChild(row);
		}
