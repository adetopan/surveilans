<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "surveilans";

$conn = new mysqli($hostname, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT disease_name, patient_count FROM epidemiology_data WHERE disease_name IN ('Hepatitis A', 'Hepatitis B')";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data['bar'][] = $row;
}

$sqlTotal = "SELECT SUM(patient_count) AS total FROM epidemiology_data";
$resultTotal = $conn->query($sqlTotal);
$totalPatients = $resultTotal->fetch_assoc()['total'];

foreach ($data['bar'] as &$row) {
    $row['percentage'] = ($row['patient_count'] / $totalPatients) * 100;
}
$data['total'] = $totalPatients;

echo json_encode($data);
?>
