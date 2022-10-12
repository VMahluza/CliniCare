<?php include_once './_header.php'; ?>

<main class="main">
    <section class="admin-panel">
        <div class="container">
            <h3>Administrator</h3>
            <form action="" method="POST">
                <div class="search-patient">
                    <input type="search" name="search-patient" id="search-patient" placeholder="search by ID of File Number...">
                    <button type="submit" id="search-btn">search</button>
                </div>
            </form>
            <button class="logout-btn" id="logout-btn">Log out</button>
        </div>
    </section>

    <section class="container">
        <table class="patients-table">
            <thead>
                <th>Identity Number</th>
                <th>File Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Sex</th>
            </thead>

            <tbody>
                <tr>
                    <td>960305567087</td>
                    <td>CC01P</td>
                    <td>Perfect</td>
                    <td>Nkosi</td>
                    <td>Male</td>
                </tr>
                <tr>
                    <td>9501025540087</td>
                    <td>CC02P</td>
                    <td>Jane</td>
                    <td>Doe</td>
                    <td>Female</td>
                </tr>
            </tbody>
        </table>
    </section>

</main>

<?php include_once './_footer.php'; ?>