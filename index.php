<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Group System</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Font Upload System</h2>

        <!-- Font Upload Form -->
        <input type="file" id="font-upload" accept=".ttf" class="form-control mb-3">
        <div class="alert alert-danger" id="font-error" style="display:none;"></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Font Name</th>
                    <th>Preview</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="font-list">
                <!-- Uploaded fonts will appear here -->
            </tbody>
        </table>

        <!-- Font Group Creation -->
        <h2 class="mt-5">Create Font Group</h2>
        <form id="font-group-form">
            <!-- Font Group Name Input -->
            <div class="mb-3">
                <label for="font-group-name">Font Group Name</label>
                <input type="text" class="form-control" id="font-group-name" name="groupName" placeholder="Enter Group Name" required>
            </div>

            <!-- Font Group Container -->
            <div id="font-group-container" class="mb-3">
                <!-- First row (one row by default) -->
                <div class="row mb-3 font-row">
                    <div class="col-md-3">
                        <label>Font Name</label>
                        <select class="form-select font-select" name="fonts[]">
                            <option value="">Select Font</option>
                            <!-- Font options will be populated dynamically -->
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
                        <button type="button" class="btn btn-danger remove-row" disabled>&times;</button>
                    </div>
                </div>
            </div>

            <!-- Add Row Button -->
            <button type="button" id="add-row" class="btn btn-secondary">Add Row</button>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Create Font Group</button>
        </form>

        <!-- Display Created Font Groups -->
        <h3 class="mt-5">Created Font Groups</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Fonts</th>
                    <th>Font Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="font-group-list">
                <!-- Created font groups will be shown here -->
            </tbody>
        </table>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
