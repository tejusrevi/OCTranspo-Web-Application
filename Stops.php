<!DOCTYPE html>

<head>
    < script type = 'text/javascript' >
    let parsedData = [];
    let r = [];
    let t = [];

    function createTable(array) {
      var queryResult = document.getElementById("queryResult");

      var table = document.createElement('table');
      //table.colSpan = "3";
      var tr = document.createElement('tr');
      var th = document.createElement('th');
      th.classList.add('route');

      var text1 = document.createTextNode(array.routeNo + " " + array.routeHeading);
      th.appendChild(text1);
      tr.appendChild(th);
      table.appendChild(tr);

      queryResult.appendChild(table);
      return table;
    }

    function createRow(table, array, j) {
      //var queryResult=document.getElementById("queryResult");
      //var table = document.createElement('table');
      var td1 = document.createElement('td');
      td1.classList.add('trip');
      if ('adjustedScheduleTime' in array) {
        var text1 = document.createTextNode(array.adjustedScheduleTime + (array.adjustmentAge > -1 ? '*' : ''));
        if (array.adjustedScheduleTime < 5) {
          td1.classList.add('arriving-soon');
        }
      } else {
        var text1 = document.createTextNode('No Scheduled trip');
        if (j == 0) {
          table.classList.add('noRoute');
        }

      }

      table.getElementsByTagName('tr')[0].appendChild(td1);
      td1.appendChild(text1);

      //cell.appendChild(text1);
    }

    function parseMultipleForAllRoutes(data) {
      var i = 0;

      while (i < data["GetRouteSummaryForStopResult"]["Routes"]["Route"].length) {
        parsedData[i] = [];
        r["routeNo"] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i].RouteNo;
        r["directionID"] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i].DirectionID;
        r["routeHeading"] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i].RouteHeading;
        var table = createTable(r);
        //alert(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"]["Trip"].length);

        if (data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].length == 0) {
          t = [];
          j = 0;
          createRow(table, t, j);
        } else if ('TripDestination' in data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"]) {
          //Last trip
          t['tripDestination'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].TripDestination;
          t['tripStartTime'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].TripStartTime;
          t['adjustedScheduleTime'] = parseInt(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].AdjustedScheduleTime);
          t['adjustmentAge'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].AdjustmentAge);
          t['lastTripOfSchedule'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].LastTripOfSchedule;
          t['busType'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].BusType;
          t['latitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].Latitude);
          t['longitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].Longitude);
          t['GPSSpeed'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].GPSSpeed);
          createRow(table, t, j);
          j++;
        }
        var j = 0;
        while (j < data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"].length) {
          t['tripDestination'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].TripDestination;
          t['tripStartTime'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].TripStartTime;
          t['adjustedScheduleTime'] = parseInt(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].AdjustedScheduleTime);
          t['adjustmentAge'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].AdjustmentAge);
          t['lastTripOfSchedule'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].LastTripOfSchedule;
          t['busType'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].BusType;
          t['latitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].Latitude);
          t['longitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].Longitude);
          t['GPSSpeed'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"][i]["Trips"][j].GPSSpeed);
          createRow(table, t, j);
          j++;

        }
        i++;
      }
    }

    function parseSingleForAllRoutes(data) {
      r["routeNo"] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"].RouteNo;
      r["directionID"] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"].DirectionID;
      r["routeHeading"] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"].RouteHeading;
      var table = createTable(r);

      if (data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]['Trip'].length == 0) {
        t = [];
        j = 0;
        createRow(table, t, j);
      } else if ('AdjustedScheduleTime' in data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"]) {
        t['tripDestination'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].TripDestination;
        t['tripStartTime'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].TripStartTime;
        t['adjustedScheduleTime'] = parseInt(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].AdjustedScheduleTime);
        t['adjustmentAge'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].AdjustmentAge);
        t['lastTripOfSchedule'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].LastTripOfSchedule;
        t['busType'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].BusType;
        t['latitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].Latitude);
        t['longitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].Longitude);
        t['GPSSpeed'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].GPSSpeed);
        createRow(table, t, j);
      } else {
        //need to double confirm length above
        var j = 0;
        while (j < data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"].length) {
          t['tripDestination'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].TripDestination;
          t['tripStartTime'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].TripStartTime;
          t['adjustedScheduleTime'] = parseInt(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].AdjustedScheduleTime);
          t['adjustmentAge'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].AdjustmentAge);
          t['lastTripOfSchedule'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].LastTripOfSchedule;
          t['busType'] = data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].BusType;
          t['latitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].Latitude);
          t['longitude'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].Longitude);
          t['GPSSpeed'] = parseFloat(data["GetRouteSummaryForStopResult"]["Routes"]["Route"]["Trips"]["Trip"][j].GPSSpeed);
          createRow(table, t, j);

          j++;
        }

      }
    }

    function GetNextTripsForStopAllRoutes(stopNo) {
      json = fetch('<URL goes here with parameters>?stopNo=' + stopNo + '&view=true')
        .then(response => {
          return response.json()
        })
        .then(data => {

          parsedData['stopNo'] = data["GetRouteSummaryForStopResult"].StopNo;
          parsedData['stopLabel'] = data["GetRouteSummaryForStopResult"].StopDescription;
          document.getElementById("stationInfo").innerHTML = parsedData['stopNo'] + " " + parsedData['stopLabel'];

          if (!("RouteNo" in data["GetRouteSummaryForStopResult"]["Routes"]["Route"])) {
            //stop serviced by multiple bus routes
            parseMultipleForAllRoutes(data);

          } else {
            //serviced by single bus route
            parseSingleForAllRoutes(data);
          }

        })
        .catch(err => {
          //Do something for an error here
        })
    }

    function ParseMultipleForSpecificRoute(data) {
      var i = 0;
      while (i < data["GetNextTripsForStopResult"]["Route"]["RouteDirection"].length) {
        r['routeNo'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i].RouteNo;
        r['routeHeading'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i].RouteLabel;
        r['requestProcessingTime'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i].RequestProcessingTime;
        var table = createTable(r);
        console.log(data["GetNextTripsForStopResult"]);
        var j = 0;
        if (!('Trip' in data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips'])) {
          t = [];
          createRow(table, t, j);
        } else if ('AdjustedScheduleTime' in data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip']) {
          t['tripDestination'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].TripDestination;
          t['tripStartTime'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].TripStartTime;
          t['adjustedScheduleTime'] = parseInt(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].AdjustedScheduleTime);
          t['adjustmentAge'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].AdjustmentAge);
          t['lastTripOfSchedule'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].LastTripOfSchedule;
          t['busType'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].BusType;
          t['latitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].Latitude);
          t['longitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].Longitude);
          t['GPSSpeed'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].GPSSpeed);
          createRow(table, t, j);
        } else {
          while (j < data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'].length) {
            t['tripDestination'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].TripDestination;
            t['tripStartTime'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].TripStartTime;
            t['adjustedScheduleTime'] = parseInt(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].AdjustedScheduleTime);
            t['adjustmentAge'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].AdjustmentAge);
            t['lastTripOfSchedule'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].LastTripOfSchedule;
            t['busType'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].BusType;
            t['latitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].Latitude);
            t['longitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].Longitude);
            t['GPSSpeed'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"][i]['Trips']['Trip'][j].GPSSpeed);
            createRow(table, t, j);
            j++;
          }
        }
        i++;
      }
    }

    function ParseSingleForSpecificRoute(data) {
      r['routeNo'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"].RouteNo;
      r['routeHeading'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"].RouteLabel;
      r['requestProcessingTime'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"].RequestProcessingTime;
      var table = createTable(r);
      var j = 0;
      if (!('Trip' in data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'])) {
        while (j < data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]["Trips"]["Trip"].length) {
          t['tripDestination'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].TripDestination;
          t['tripStartTime'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].TripStartTime;
          t['adjustedScheduleTime'] = parseInt(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].AdjustedScheduleTime);
          t['adjustmentAge'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].AdjustmentAge);
          t['lastTripOfSchedule'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].LastTripOfSchedule;
          t['busType'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].BusType;
          t['latitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].Latitude);
          t['longitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].Longitude);
          t['GPSSpeed'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'][j].GPSSpeed);
          createRow(table, t, j);
          j++
        }
      } else if ('AdjustedScheduleTime' in data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']) {

        t['tripDestination'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].TripDestination;
        t['tripStartTime'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].TripStartTime;
        t['adjustedScheduleTime'] = parseInt(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].AdjustedScheduleTime);
        t['adjustmentAge'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].AdjustmentAge);
        t['lastTripOfSchedule'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].LastTripOfSchedule;
        t['busType'] = data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].BusType;
        t['latitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].Latitude);
        t['longitude'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].Longitude);
        t['GPSSpeed'] = parseFloat(data["GetNextTripsForStopResult"]["Route"]["RouteDirection"]['Trips']['Trip'].GPSSpeed);
        createRow(table, t, j);

      } else {
        t = [];
        createRow(table, t, j);
      }
    }

    function GetNextTripsForStop(stopNo, routeNo) {
      let json = fetch('<URL goes here with parameters>')
        .then(response => {
          return response.json()
        })
        .then(data => {
          let parsedData = [];
          parsedData['stopNo'] = data["GetNextTripsForStopResult"].StopNo;
          parsedData['stopLabel'] = data["GetNextTripsForStopResult"].StopLabel;
          document.getElementById("stationInfo").innerHTML = parsedData['stopNo'] + " " + parsedData['stopLabel'];
          if (!("RouteNo" in data["GetNextTripsForStopResult"]["Route"]["RouteDirection"])) {
            //stop serviced by multiple bus routes
            ParseMultipleForSpecificRoute(data);
          } else {
            //serviced by single bus route

            ParseSingleForSpecificRoute(data);
          }
        })
        .catch(err => {
          // Do something for an error here
        })
    } <
    /script>

</head>
<body>

<div id="form">
<form action="" method="GET">
    Stop Number:<br>
    <input list="stop-list" name="stopNo">
    <datalist id="stop-list">
    </datalist>
    <script src="stopList.js"></script>
    <br>
    Route Number:<br>
    <input type="text" name="routeNo" placeholder="eg. 87">
    <br><br>
    <input type="submit" value="Submit">
</form>
</div>

<div id="meta">
<p id="stationInfo"></p>
</div>

<div id="queryResult">
</div>

<?php
if (isset($_GET['stopNo'])){
    if (isset($_GET['routeNo']) && $_GET['routeNo']!=''){
        echo "<script type='text/javascript'>
             GetNextTripsForStop(".substr($_GET['stopNo'],0,4).",".$_GET['routeNo'].");
             </script>";
    }
    else{
        echo "<script type='text/javascript'>
             GetNextTripsForStopAllRoutes(".substr($_GET['stopNo'],0,4).");
             </script>";
    }

     }
?>
</body>

</html>