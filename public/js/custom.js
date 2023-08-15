/**
* @desc For sending data into the
* groups route for storing groups process
*/
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addGroupForm').on('submit', function(event){
        event.preventDefault();

        $('#loader').show();

        let groupName = $("input[name='groupName']").val();
        let storeUrl = document.querySelector("#groupRoute").getAttribute("data-store-url");

        $.ajax({
            url: storeUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: groupName,
            },
            success: function(data){
                $('#responseMessage').html('<div class="alert alert-success">'+data.message+'</div>');
                setTimeout(function(){
                    $('#responseMessage .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
                let newRow = `
                    <tr>
                        <th scope="row">${data.group.id}</th>
                        <td>
                            <a href="#" style="text-decoration: none"
                               data-id=${data.group.id }
                               class="groupNameIdentifier"
                            >
                                ${data.group.name}
                            </a>
                        </td>
                        <td>
                            <a href="#" class="mb-2">
                                <i class="fas fa-pen"></i>
                            </a>
                        </td>
                        <td>
                            <a href="#" class="mb-2">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
                $('#groupsTableBody').append(newRow);
                $('#groupName').val('');
                if ($("#groupsTableBody tr").length > 1) {
                    $("#groupsTableBody tr:contains('The table is empty.')").remove();
                }
                $("#groupsTableMainDiv").load(location.href + " #groupsTableMainDiv");
                $("#groupsPagination").load(location.href + " #groupsPagination");
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(xhr){
                if (xhr.status === 422 && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    let errorMessage = '';
                    for (let field in response.message) {
                        errorMessage += response.message[field].join(',       ');
                    }
                    $('#responseMessage').html('<div class="alert alert-danger">'+errorMessage+'</div>');
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">An unexpected error occurred</div>');
                }

                setTimeout(function(){
                    $('#responseMessage .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    });
});

/**
* @desc For sending data into the
* groups route for updating process
*/
$(document).on('click', '.editGroupButton', function(e) {
    e.preventDefault();

    $('#loader').show();

    let groupId = $(this).data('id');

    $.ajax({
        url: `/groups/${groupId}/edit`,
        method: 'GET',
        success: function(response) {
            $('#groupNameEdit').val(response.group.name);
            $('#groupIdEdit').val(response.group.id);
            $('#editGroupForm').attr('action', `/groups/${groupId}`);
            $('#exampleModalGroupEdit').modal('show');
        },
        complete: function() {
            $('#loader').hide();
        },
        error: function(xhr){
            if (xhr.status === 422 && xhr.responseJSON) {
                let response = xhr.responseJSON;
                let errorMessage = '';
                for (let field in response.message) {
                    errorMessage += response.message[field].join(',       ');
                }
                $('#responseMessageEdit').html('<div class="alert alert-danger">'+errorMessage+'</div>');
            } else {
                $('#responseMessageEdit').html('<div class="alert alert-danger">An unexpected error occurred</div>');
            }
            setTimeout(function(){
                $('#responseMessageEdit .alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });
});

/**
* @desc For sending data into the
* groups route for deleting groups data
*/
$(document).on('click', '.deleteGroupButton', function(e) {
    e.preventDefault();
    $('#loader').show();

    let groupId = $(this).data('id');
    let currentRow = $(this).closest('tr');

    if (confirm("Are you sure you want to delete this group?")) {
        $.ajax({
            url: `/groups/${groupId}`,
            method: 'POST',
            data: {
                _method: 'DELETE',
            },
            success: function(response) {
                currentRow.remove();
                $('#responseMessageTable').html('<div class="alert alert-success">Group  deleted successfully</div>');
                setTimeout(function(){
                    $('#responseMessageTable .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(xhr){
                if (xhr.status === 422 && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    let errorMessage = '';
                    for (let field in response.message) {
                        errorMessage += response.message[field].join(',       ');
                    }
                    $('#responseMessageTable').html('<div class="alert alert-danger">'+errorMessage+'</div>');
                } else {
                    $('#responseMessageTable').html('<div class="alert alert-danger">An unexpected error occurred</div>');
                }
                setTimeout(function(){
                    $('#responseMessageTable .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    }
});

/**
* @desc For populating data into the
* groups select box
*/
$(document).on('click', '.addEmailButton', function(e) {
    e.preventDefault();

    $('#loader').show();

    $.ajax({
        url: "/groups",
        method: 'GET',
        success: function(response) {
            let groupSelect = $('select[name="emailGroups"]');
            groupSelect.empty();

            groupSelect.append($('<option>', {
                value: '',
                text: 'Select Group'
            }));

            $.each(response, function(index, group) {
                groupSelect.append($('<option>', {
                    value: group.id,
                    text: group.name
                }));
            });
        },
         complete: function() {
            $('#loader').hide();
        },
        error: function(error) {
            console.error('Failed to fetch groups.', error);
        }
    });
});

/**
* @desc For sending data into the
* customers route for adding customer
* data to groups
*/
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addCustomerEmailForm').on('submit', function(event){
        event.preventDefault();

         $('#loader').show();

        let formData = $(this).serialize();
        $.ajax({
            url: '/customers',
            method: 'POST',
            data: formData,
            success: function(response) {
                $("#addCustomerEmailForm")[0].reset();
                if (response.status = "success") {
                    $('#responseMessageEmail').html('<div class="alert alert-success">'+response.message+'</div>');
                } else {
                    $('#responseMessageEmail').html('<div class="alert alert-danger">An unexpected error occurred.</div>');
                }
                setTimeout(function(){
                  $('#responseMessageEmail .alert').fadeOut('slow', function() {
                      $(this).remove();
                  });
                }, 5000);
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(xhr) {
               if (xhr.status === 422 && xhr.responseJSON) {
                   let response = xhr.responseJSON;
                   let errorMessage = '';
                   for (let field in response.message) {
                       errorMessage += response.message[field].join(', ');
                   }
                    $('#responseMessageEmail').html('<div class="alert alert-danger">'+errorMessage+'</div>');
               } else {
                    $('#responseMessageEmail').html('<div class="alert alert-danger">An unexpected error occurred.</div>');
               }
               setTimeout(function(){
                  $('#responseMessageEmail .alert').fadeOut('slow', function() {
                      $(this).remove();
                  });
               }, 5000);
            }
        });
    });
});

/**
* @desc For populating data into the
* customer emails table
*/
$(document).ready(function(){
    $('.groupNameIdentifier').on('click', function(e){
        e.preventDefault();

        $('#loader').show();

        let groupId = $(this).data('id');
        $.ajax({
            url: `/customers/${groupId}`,
            type: 'GET',
            success: function(data) {
                $('#exampleModalEmails').modal('show');
                let tableBody = $("#customerEmailsTable");
                if (data.length > 0) {
                    data.forEach((customer, index) => {
                        tableBody += `
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${customer.first_name}</td>
                            <td>${customer.last_name}</td>
                            <td>${customer.email}</td>
                            <td>${customer.sex}</td>
                            <td>${customer.birth_date ? new Date(customer.birth_date).toLocaleDateString() : 'N/A'}</td>
                        </tr>`;
                    });
                } else {
                    tableBody = `<tr><td colspan="6" class="text-center">The table is empty.</td></tr>`;
                }
                $('#exampleModalEmails tbody').html(tableBody);
            },

            complete: function() {
                $('#loader').hide();
            },

            error: function(xhr) {
               if (xhr.status === 404 && xhr.responseJSON) {
                    $('#exampleModalEmails').modal('show');

                    $('#responseMessageEmail').html('<div class="alert alert-danger">There is not email in this group</div>');
               } else {
                    $('#responseMessageEmail').html('<div class="alert alert-danger">An unexpected error occurred</div>');
               }
               setTimeout(function(){
                   $('#responseMessageEmail .alert').fadeOut('slow', function() {
                       $(this).remove();
                   });
               }, 5000);
            }
        });
    });
});

/**
* @desc For editing and updating
* the groups table
*/
$(document).ready(function(){
    $('#editGroupForm').on('submit', function(event){
        event.preventDefault();

        $('#loader').show();

        let groupId = $("#groupIdEdit").val();

        $.ajax({
            url: `/groups/${groupId}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: 'PUT',
                name: $("#groupNameEdit").val()
            },
            success: function(data){
                $('#responseMessage').html('<div class="alert alert-success">'+data.message+'</div>');
                $(`#groupsTableBody .groupNameIdentifier[data-id="${groupId}"]`).text(data.group.name);
                $('#exampleModalGroupEdit').modal('hide');
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(xhr){
                if (xhr.status === 422 && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    let errorMessage = '';
                    for (let field in response.message) {
                        errorMessage += response.message[field].join(', ');
                    }
                    $('#responseMessage').html('<div class="alert alert-danger">'+errorMessage+'</div>');
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">An unexpected error occurred.</div>');
                }
            }
        });
    });
});

/**
* @desc For saving email template into
* the email template table
*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#exampleModalTemplate form").submit(function (e) {
        e.preventDefault();

        $('#loader').show();

        let templateRoute = document.querySelector("#templateRoute").getAttribute("data-store-url");

        $.ajax({
            url: templateRoute,
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === "success") {
                    $('#responseMessageEmailTemplate').html('<div class="alert alert-success">Templates saved successfully!</div>');
                }else{
                    $('#responseMessageEmailTemplate').html('<div class="alert alert-danger">An unexpected error occurred!</div>');
                }
                setTimeout(function(){
                    $('#responseMessageEmailTemplate .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON) {
                    let response = xhr.responseJSON;
                    let errorMessage = '';
                    for (let field in response.message) {
                        errorMessage += response.message[field].join(',       ');
                    }
                        $('#responseMessageEmailTemplate').html('<div class="alert alert-danger">'+errorMessage+'</div>');
                } else {
                    $('#responseMessageEmailTemplate').html('<div class="alert alert-danger">An unexpected error occurred!</div>');
                }
                setTimeout(function(){
                    $('#responseMessageEmailTemplate .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    });
});

/**
* @desc For sending data to route populating
* data into the send mail select boxes
*/
$(document).on('click', '.sendEmailButton', function(e) {
    e.preventDefault();

    $('#loader').show();

    $.ajax({
        url: "templates/show",
        method: 'GET',
        success: function(data) {
            let groupSelect = $('select[name="emailGroups"]');
            groupSelect.empty();
            groupSelect.append($('<option>', {
                value: '',
                text: 'Select Group'
            }));
            $.each(data.groups, function(index, group) {
                groupSelect.append($('<option>', {
                    value: group.id,
                    text: group.name
                }));
            });

            let templateSelect = $('select[name="emailTemplates"]');
            templateSelect.empty();
            templateSelect.append($('<option>', {
                value: '',
                text: 'Select Template'
            }));
            $.each(data.templates, function(index, template) {
                templateSelect.append($('<option>', {
                    value: template.id,
                    text: template.subject
                }));
            });
        },
        complete: function() {
            $('#loader').hide();
        },
        error: function(error) {
            console.error('Failed to fetch data.', error);
        }
    });
});

/**
* @desc method For sending data to route
* for sending emails immediately
*/
$(document).on('submit', '#sendMailsForm', function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    e.preventDefault();

    $('#loader').show();

    let formData = $(this).serialize();

    $.ajax({
        url: "/templates/send",
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.status == 'success') {
                $("#sendMailsForm")[0].reset();
                $('#responseMessageSend').html('<div class="alert alert-success">Emails scheduled successfully!</div>');
                setTimeout(function(){
                    $('#responseMessageSend .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            } else {
                $('#responseMessageSend').html('<div class="alert alert-danger">An unexpected error occured. Please try again later.</div>');
            }
            setTimeout(function(){
                $('#responseMessageSend .alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        },
        error: function(xhr) {
             if (xhr.status === 422 && xhr.responseJSON) {
                let response = xhr.responseJSON;
                let errorMessage = '';
                for (let field in response.message) {
                    errorMessage += response.message[field].join(',       ');
                }
                $('#responseMessageSend').html('<div class="alert alert-danger">'+errorMessage+'</div>');
            } else {
                $('#responseMessageSend').html('<div class="alert alert-danger">An unexpected error occured. Please try again later.</div>');
            }
            setTimeout(function(){
                $('#responseMessageSend .alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        },
        complete: function() {
            $('#loader').hide();
        }
    });
});

/**
* @desc configurations for the
* tiny-mce text area for the
* Email templates
*/
tinymce.init({
    selector: '#editor',
    toolbar: 'undo redo | placeholders | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent', // Added placeholders
    setup: function (editor) {
        editor.ui.registry.addMenuButton('placeholders', {
            text: 'Placeholders',
            fetch: function (callback) {
                var items = [
                    {type: 'menuitem', text: 'First Name', onAction: function () {editor.insertContent('{first_name}');}},
                    {type: 'menuitem', text: 'Last Name', onAction: function () {editor.insertContent('{last_name}');}},
                    {type: 'menuitem', text: 'Email', onAction: function () {editor.insertContent('{email}');}}
                ];
                callback(items);
            }
        });
    }
});

/**
* @desc hide and unhide schedule date when checkbox is clicked.
*/
$(document).ready(function(){
    $('#shouldSchedule').change(function(){
        if($(this).prop("checked")) {
            $('#sendFutureDisplay').show();
        } else {
            $('#sendFutureDisplay').hide();
        }
    });
});



