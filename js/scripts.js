$(document).ready(function () {
    let uploadedFonts = [];
    let fontGroups = []; // Store font groups for editing purposes

    // Handle font upload
    $('#font-upload').on('change', function () {
        console.log('test');
        var formData = new FormData();
        formData.append('font-file', this.files[0]);

        $.ajax({
            url: 'api/index.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.error) {
                    $('#font-error').text(response.error).show();
                } else {
                    $('#font-error').hide();
                    addFontToList(response.fontName, response.fontUrl);
                    uploadedFonts.push(response.fontName); // Add font to the list
                    populateFontSelects(); // Refresh the font dropdowns
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });

        $('#font-upload').val(''); // Reset the file input
    });

    // Add uploaded font to the list
    function addFontToList(fontName, fontUrl) {
        var fontRow = `
            <tr data-font-url="${fontUrl}">
                <td>${fontName}</td>
                <td style="font-family: '${fontName}';">Example Text</td>
                <td>
                    <button class="btn btn-danger delete-font" data-font-url="${fontUrl}" data-font-name="${fontName}">Delete</button>
                </td>
            </tr>
        `;
        $('#font-list').append(fontRow);
    }

    // Delete font from list and dropdown
    $(document).on('click', '.delete-font', function () {
        var fontUrl = $(this).data('font-url');
        var fontName = $(this).data('font-name');
        var row = $(this).closest('tr');

        $.ajax({
            url: 'api/index.php',
            type: 'POST',
            data: { fontUrl: fontUrl },
            success: function (response) {
                row.remove();
                uploadedFonts = uploadedFonts.filter(font => font !== fontName);
                populateFontSelects();
            }
        });
    });

    // Populate font dropdowns
    function populateFontSelects() {
        $('.font-select').each(function () {
            $(this).html('<option value="">Select Font</option>');
            uploadedFonts.forEach(font => {
                $(this).append(`<option value="${font}">${font}</option>`);
            });
        });
    }

    // Add new row for font group
    $('#add-row').on('click', function () {
        const newRow = `
            <div class="row mb-3 font-row">
                <div class="col-md-3">
                    <label>Font Name</label>
                    <select class="form-select font-select" name="fonts[]">
                        <option value="">Select Font</option>
                        ${uploadedFonts.map(font => `<option value="${font}">${font}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Specific Size</label>
                    <input type="number" class="form-control" name="sizes[]" placeholder="Enter size">
                </div>
                <div class="col-md-3">
                    <label>Price Change</label>
                    <input type="number" class="form-control" name="prices[]" placeholder="Enter price change">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-row">&times;</button>
                </div>
            </div>
        `;
        $('#font-group-container').append(newRow);
    });

    // Remove a row from the group
    $(document).on('click', '.remove-row', function () {
        $(this).closest('.font-row').remove();
    });

    // Handle font group submission (Create New Group)
    $('#font-group-form').on('submit', function (e) {
        e.preventDefault();

        const groupName = $('#font-group-name').val().trim();
        const selectedFonts = $('select[name="fonts[]"]').map(function () {
            return $(this).val();
        }).get().filter(Boolean);

        if (selectedFonts.length < 2) {
            alert('You must select at least two fonts.');
            return;
        }

        if (!groupName) {
            alert('Font group name is required.');
            return;
        }

        const groupData = {
            groupName,
            fonts: selectedFonts
        };

        // Add group to the list and store it for editing purposes
        fontGroups.push(groupData);
        addFontGroupToList(fontGroups.length - 1, groupData);

        // Reset form after submission
        $('#font-group-form')[0].reset();
        $('#font-group-container').find('.font-row:not(:first)').remove();
    });

    // Function to display created font groups
    function addFontGroupToList(groupIndex, groupData) {
        const fontNames = groupData.fonts.join(', ');
        const fontCount = groupData.fonts.length;

        const fontGroupRow = `
            <tr data-group-index="${groupIndex}">
                <td>${groupData.groupName}</td>
                <td>${fontNames}</td>
                <td>${fontCount}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-group">Edit</button>
                    <button class="btn btn-danger btn-sm delete-group">Delete</button>
                </td>
            </tr>
        `;
        $('#font-group-list').append(fontGroupRow);
    }

    // Delete a font group
    $(document).on('click', '.delete-group', function () {
        const row = $(this).closest('tr');
        const groupIndex = row.data('group-index');

        // Remove the group from the fontGroups array
        fontGroups.splice(groupIndex, 1);

        // Re-render the table
        renderFontGroups();

        // Optional: Delete from the database via an AJAX request
    });

    // Edit a font group
    $(document).on('click', '.edit-group', function () {
        const row = $(this).closest('tr');
        const groupIndex = row.data('group-index');
        const groupData = fontGroups[groupIndex];

        // Populate the form with the existing group data
        $('#font-group-name').val(groupData.groupName);

        // Clear existing font rows
        $('#font-group-container').empty();

        // Populate font rows with the group's fonts
        groupData.fonts.forEach((font, index) => {
            const newRow = `
                <div class="row mb-3 font-row">
                    <div class="col-md-3">
                        <label>Font Name</label>
                        <select class="form-select font-select" name="fonts[]">
                            <option value="">Select Font</option>
                            ${uploadedFonts.map(f => `<option value="${f}" ${f === font ? 'selected' : ''}>${f}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Specific Size</label>
                        <input type="number" class="form-control" name="sizes[]" value="${groupData.sizes ? groupData.sizes[index] : ''}" placeholder="Enter size">
                    </div>
                    <div class="col-md-3">
                        <label>Price Change</label>
                        <input type="number" class="form-control" name="prices[]" value="${groupData.prices ? groupData.prices[index] : ''}" placeholder="Enter price change">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-row">&times;</button>
                    </div>
                </div>
            `;
            $('#font-group-container').append(newRow);
        });

        // Remove the group from the list so it can be re-added on submit
        fontGroups.splice(groupIndex, 1);
        row.remove();

        // Scroll to the form for easy editing
        $('html, body').animate({
            scrollTop: $('#font-group-form').offset().top
        }, 500);
    });

    // Re-render font groups after deleting/editing
    function renderFontGroups() {
        $('#font-group-list').empty();
        fontGroups.forEach((group, index) => {
            addFontGroupToList(index, group);
        });
    }
});
