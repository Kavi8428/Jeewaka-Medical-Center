<!DOCTYPE html>
<html>
<head>
    <title>PATIENTS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../../../assets/css/material-dashboard.css?v=3.0.6" rel="stylesheet" /></head>
<body>
<nav class="navbar navbar-main navbar-expand-lg position-sticky top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        
        <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
          <h2>PATIENTS</h2>
        </div>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
         
          <ul class="navbar-nav  justify-content-end">
           
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
        <a class="navbar-brand active" href="../../../dashboard.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
          target="_blank">
          HOME
        </a>
        <a class="navbar-brand active" href="./grn.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
          target="_blank">
          GRN LIST
        </a>
        <a class="navbar-brand" href="./items.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
          target="_blank">
         ITEMS
        </a>
        <a class="navbar-brand" href="./companies.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
          target="_blank">
         COMPANIES
        </a>
        <a class="navbar-brand" href="./reportGenerator.php" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom"
          target="_blank">
         REPORTS
        </a>
        <ul class="navbar-nav  justify-content-end">
          <li class="nav-item px-3">
            <a href="../../../../index.php" class="nav-link text-body p-0" data-toggle="tooltip" data-placement="top" title="Log Out" >
           LOG OUT <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>    <div id="example"></div>

    <script>
    // Function to convert a date string to Sri Lankan time format
    function convertToSriLankanTime(dateString) {
        const date = new Date(dateString);
        // Offset for Sri Lanka Standard Time (SLST) is UTC+5:30
        const sriLankanOffset = 5.5 * 60 * 60 * 1000;
        const sriLankanTime = new Date(date.getTime() + sriLankanOffset);
        
        // Format the date to yyyy/mm/dd
        const formattedDate = sriLankanTime.getFullYear() + '/' + 
                              String(sriLankanTime.getMonth() + 1).padStart(2, '0') + '/' + 
                              String(sriLankanTime.getDate()).padStart(2, '0');
        
        // Format the time to hh:mm:ss AM/PM
        const formattedTime = sriLankanTime.toLocaleTimeString();
        
        return `${formattedDate} ${formattedTime}`; // Concatenate date and time
    }

    // Fetch data from the PHP script
    fetch('../../../../attributes/fetchPatientDeta.php')
        .then(response => response.json())
        .then(data => {
            // Extract and filter relevant fields for Handsontable
            console.log('data', data);
            const hotData = data
                .filter(item => item.name && item.name.trim() !== '' && item.dob !== '0000-00-00')
                .map(item => ({
                    serial: item.serial,
                    name: item.name,
                    dob: item.dob,
                    tel: item.tel,
                    lv: convertToSriLankanTime(item.created_at) ,// Convert to Sri Lankan time
                    jd: item.jd,
                    jmc:item.jmc,
                    received:item.received,
                    remain:item.remain

                }));

            // Create Handsontable instance
            const container = document.getElementById('example');
            const hot = new Handsontable(container, {
                data: hotData,
                colHeaders: ['Serial', 'Name', 'Date of Birth', 'Telephone', 'Date & Time', 'JD', 'JMC','Received','NP'],
                columns: [
                    { data: 'serial' },
                    { data: 'name' },
                    { data: 'dob' },
                    { data: 'tel' },
                    { data: 'lv' },
                    { data: 'jd' },
                    { data: 'jmc' },
                    { data: 'received' },
                    { data: 'remain' }

                ],
                rowHeaders: true,
                width: '100%',
                height: 550,
                stretchH: 'all',
                filters: true,
                fixedRowsTop: 0,  // Fix the headers
                licenseKey: 'non-commercial-and-evaluation', // for non-commercial use
                dropdownMenu: true,
                columnSorting: true  
            });
        })
        .catch(error => console.error('Error:', error));
</script>

</body>
</html>
