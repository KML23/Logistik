        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            // Add new task
            function addItem() {
                var taskText = document.getElementById("new-task").value;
                if (taskText.trim() !== "") {
                    var li = document.createElement("li");
                    li.innerHTML = `
                        <span class="handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <input type="checkbox" class="todo-checkbox">
                        <span class="text">${taskText}</span>
                        <small class="label label-info"><i class="fa fa-clock-o"></i> New task</small>
                        <div class="tools">
                            <i class="fa fa-edit" onclick="editItem(this)"></i>
                            <i class="fa fa-trash-o" onclick="deleteItem(this)"></i>
                        </div>
                    `;
                    document.getElementById("todo-list").appendChild(li);
                    document.getElementById("new-task").value = "";
                }
            }

            // Mark task as completed
            $(document).on("change", ".todo-checkbox", function() {
                var parentLi = $(this).closest("li");
                parentLi.toggleClass("checked");
            });

            // Edit task directly in the list
            function editItem(element) {
                var parentLi = $(element).closest("li");
                var currentText = parentLi.find(".text").text();
                
                // Convert the text to an input field for editing
                var inputField = `<input type="text" class="edit-input" value="${currentText}" />`;
                parentLi.find(".text").html(inputField);
                
                // Focus on the input field
                parentLi.find(".edit-input").focus().blur(function() {
                    var newText = $(this).val().trim();
                    if (newText !== "") {
                        parentLi.find(".text").html(newText);
                    } else {
                        parentLi.find(".text").html(currentText); // Restore if empty
                    }
                });
            }

            // Delete task
            function deleteItem(element) {
                var parentLi = $(element).closest("li");
                parentLi.remove();
            }
        </script>