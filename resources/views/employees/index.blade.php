<x-layout>
    <div class="relative p-3 overflow-x-auto shadow-md sm:rounded-lg">
        <div class="">

            <h1
                class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-700 md:text-5xl lg:text-6xl dark:text-white">
                Employees
            </h1>
            <h1 id="total_emp"
                class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-700  dark:text-white">
                Total: 0
            </h1>

        </div>

        <div class="lg:flex justify-center  lg:justify-between  items-center">
            <div
                class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white">
                <button id="btn-add-emp" data-modal-target="empModal" data-modal-toggle="empModal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button" title="Add Employee">
                    Add
                </button>
            </div>
            <div>

                <div id="date-range-picker" date-rangepicker class="flex items-center">
                    <span class="font-bold px-2">Filter by Joining Date: </span>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="datepicker-range-start" name="start" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select start date">
                    </div>
                    <span class="mx-4 text-gray-500">to</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="datepicker-range-end" name="end" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select end date">
                    </div>
                    <div class="mx-4">
                        <button id="btn-find-emp"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button" title="Find">
                            Find
                        </button>
                    </div>
                </div>

            </div>


        </div>


        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Emp. Code</th>
                    <th scope="col" class="px-6 py-3">Profile Image</th>
                    <th scope="col" class="px-6 py-3">Full Name</th>
                    <th scope="col" class="px-6 py-3">Joining Date</th>
                    <th scope="col" class="px-6 py-3">Actions</th>

                </tr>
            </thead>
            <tbody id="employee-table-body">
            </tbody>
        </table>

    </div>


    <div id="pagination-links" class="mt-4">

    </div>

    <x-emp.modal-form />

</x-layout>

<script type="module">
    $(document).ready(function() {
        const $targetEl = document.getElementById('empModal');

        // Modal options with default values
        const options = {
            placement: 'bottom-right',
            backdrop: 'static',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {

                $('#add-employee-form').trigger('reset');
                $('#edit-employee-form').trigger('reset');
                console.log('modal is hidden');
            },
            onShow: () => {
                console.log('modal is shown');
            },
            onToggle: () => {
                console.log('modal has been toggled');
            },
        };

        // Instance options object
        const instanceOptions = {
            id: 'empModal',
            override: true
        };

        const modal = new Modal($targetEl, options, instanceOptions);

        // Function to load employees and handle pagination
        function loadEmployees(page, startDate = null, endDate = null) {
            let url = '/api/employees?page=' + page;
            if (startDate && endDate) {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }
            $.ajax({
                url: url,
                success: function(response) {
                    $('#total_emp').text(`Total: ${response.meta.total}`)


                    var rows = '';
                    var editButtonSvg = `<svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                        </svg>
                        `;
                    var trashButtonSvg = `<svg class="w-6 h-6 text-red" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                            </svg>
                            `;
                    $.each(response.data, function(index, employee) {
                        rows += `<tr>
                        <td class="px-6 py-4">${employee.emp_code}</td>
                        <td class="px-6 py-4">
                            ${employee.profile_image ?
                                `<img src="/storage/profile_images/${employee.profile_image}" alt="Profile Image" class="w-16 h-16 rounded-full object-cover" />` :
                                'N/A'}
                        </td>
                        <td class="px-6 py-4">${employee.first_name} ${employee.last_name}</td>
                        <td class="px-6 py-4">${employee.joining_date ? employee.joining_date : 'N/A'}</td>
                        <td class="px-6 py-4 flex">
                            <a href="#" class="edit-employee-link text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 me-2 mb-2" data-id="${employee.id}" title="Edit Employee">${editButtonSvg}</a>
                            <a href="#" class="delete-employee-link text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm p-2 me-2 mb-2" data-id="${employee.id}" title="Delete Employee">${trashButtonSvg}</a>
                        </td>
                    </tr>`;
                    });

                    $('#employee-table-body').html(rows);
                    // pagination

                    var pagination =
                        '<nav aria-label="Page navigation example"><ul class="inline-flex -space-x-px text-base h-10">';

                    if (response.meta.current_page > 1) {
                        pagination += '<li>' +
                            '<a href="#" data-page="' + (response.meta.current_page - 1) +
                            '" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>' +
                            '</li>';
                    }

                    // Page Links
                    $.each(response.meta.links, function(index, link) {
                        if (link.url) {
                            var pageNumber = link.url.split('page=')[1];
                            pagination += '<li>' +
                                '<a href="#" data-page="' + pageNumber +
                                '" class="flex items-center justify-center px-4 h-10 leading-tight ' +
                                (link.active ?
                                    'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' :
                                    'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
                                ) +
                                '">' + link.label + '</a></li>';
                        }
                    });

                    // Next Page Link
                    if (response.meta.current_page < response.meta.last_page) {
                        pagination += '<li>' +
                            '<a href="#" data-page="' + (response.meta.current_page + 1) +
                            '" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>' +
                            '</li>';
                    }

                    pagination += '</ul></nav>';
                    $('#pagination-links').html(pagination);
                }
            });
        }

        loadEmployees(1);

        // Handle Add Employee button click
        $('#btn-add-emp').on('click', function() {
            showAddEmployeeModal();
        });

        // Handle Add Employee form submission
        function handleAddEmployeeFormSubmit(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);

            $.ajax({
                url: '/api/employees', // Adjust the URL to your endpoint
                type: 'POST',
                data: formData,
                contentType: false, // Set contentType to false when sending FormData
                processData: false, // Prevent jQuery from automatically processing the data
                success: function(response) {
                    console.log('Employee added successfully:', response);
                    modal.hide(); // Hide the modal
                    loadEmployees(1); // Reload the employees
                    showToast('Employee added successfully'); // Show success toast
                },
                error: function(xhr) {
                    var response = xhr.responseJSON || {};


                    var errorMessage = response.message || 'An unknown error occurred.';
                    showToast(errorMessage, 'error');
                }

            });
        }

        // Handle Edit Employee button click
        function handleEditEmployeeClick(e) {
            e.preventDefault();
            var employeeId = $(this).data('id');

            $.ajax({
                url: '/api/employees/' + employeeId,
                success: function(data) {
                    const employee = data.data

                    $('#first_name').val(employee.first_name);
                    $('#last_name').val(employee.last_name);
                    $('#joining_date').val(employee.joining_date);
                    $('#emp-modal-title').text('Edit Employee');
                    $('#add-employee-form').attr('id', 'edit-employee-form').data('id', employee
                        .id);

                    $('#edit-employee-form').data('id', employee.id);

                    modal.show(); // Show the modal
                }
            });
        }

        // Handle Edit Employee form submission
        function handleEditEmployeeFormSubmit(e) {
            e.preventDefault();

            var employeeId = $(this).data('id');

            var formData = new FormData(this);

            $.ajax({
                url: '/api/employees/' + employeeId,
                type: 'POST',
                data: formData,
                contentType: false, // Set contentType to false when sending FormData
                processData: false, // Prevent jQuery from automatically processing the data
                success: function(response) {
                    console.log('Employee updated successfully:', response);
                    modal.hide(); // Hide the modal
                    loadEmployees(1); // Reload the employee list
                    showToast('Employee updated successfully'); // Show success toast
                },
                error: function(xhr) {
                    var response = xhr.responseJSON || {};


                    var errorMessage = response.message || 'An unknown error occurred.';
                    showToast(errorMessage, 'error');
                }


            });
        }

        // Handle Delete Employee button click
        function handleDeleteEmployeeClick(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this employee?')) {
                var employeeId = $(this).data('id');

                $.ajax({
                    url: '/api/employees/' + employeeId,
                    type: 'DELETE',
                    success: function(response) {
                        console.log('Employee deleted successfully:', response);
                        loadEmployees(1); // Reload the employee list
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON || {};


                        var errorMessage = response.message || 'An unknown error occurred.';
                        showToast(errorMessage, 'error');
                    }
                });
            }
        }

        // Handle pagination link clicks
        function handlePaginationClick(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) {
                loadEmployees(page);
            }
        }

        // Function to show the Add Employee modal
        function showAddEmployeeModal() {

            $('#add-employee-form').trigger('reset');
            $('#edit-employee-form').trigger('reset');

            $('#emp-modal-title').text('Add Employee');
            $('#add-employee-form').attr('id', 'add-employee-form');
            $('#edit-employee-form').attr('id', 'add-employee-form');
            modal.show(); // Show the modal
        }

        // Handle Add Employee form submission
        $(document).on('submit', '#add-employee-form', handleAddEmployeeFormSubmit);

        // Handle Edit Employee button click
        $(document).on('click', '.edit-employee-link', handleEditEmployeeClick);

        // Handle Edit Employee form submission
        $(document).on('submit', '#edit-employee-form', handleEditEmployeeFormSubmit);

        // Handle Delete Employee button click
        $(document).on('click', '.delete-employee-link', handleDeleteEmployeeClick);

        // Handle pagination link clicks
        $(document).on('click', '#pagination-links a', handlePaginationClick);

        // Handle modal close
        $(document).on('click', '[data-modal-hide="empModal"]', function() {
            modal.hide(); // Hide the modal
        });

        // Toast
        function showToast(message, type = 'success') {
            const toast = $('#toast-top-right');
            let toastClass = '';

            // Determine the class based on the toast type
            switch (type) {
                case 'success':
                    toastClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                    break;
                case 'error':
                    toastClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                    break;
                case 'warning':
                    toastClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                    break;
                default:
                    toastClass = 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
            }

            toast.removeClass(
                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
            );
            toast.addClass(toastClass);
            toast.find('.text-sm').text(message);
            toast.fadeIn(400).delay(3000).fadeOut(400);
        }

        // Filters
        // Date range picker
        $('#btn-find-emp').on('click', function() {
            const startDate = $('#datepicker-range-start').val();
            const endDate = $('#datepicker-range-end').val();

            loadEmployees(1, startDate, endDate);
        });
    });
</script>



{{-- Toast --}}
<div id="toast-top-right"
    class="fixed z-50 flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow top-5 right-5 dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800"
    role="alert" style="display: none;">
    <div class="text-sm font-normal"></div>
</div>
