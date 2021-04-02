<?php
    require ('connection.php');

    error_reporting(E_ERROR | E_PARSE);

    $subjectid = $_POST['subjectid'];

    $query = "SELECT date FROM exams WHERE subjectid = '$subjectid'";
    $result = mysqli_query($db,$query);
    $row = $result->fetch_assoc();
    $exam_date = $row['date'];
    $today = date("Y-m-d");

    if($exam_date == ""){
        echo "Aun no se ha puesto fecha de examen.";
    }elseif($exam_date > $today){
        echo "<p>Aun no se ha realizado el examen. Espera hasta $exam_date.</p>";
    } elseif($exam_date == $today) {
        echo "<p>Hoy se ha realizado el examen, mañana se publicarán las notas.</p>";
    } elseif($exam_date < $today) {
        $query = "SELECT name FROM subjects WHERE subjectid = '$subjectid'";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        $subject_name = $row['name'];
    
        $query = "SELECT DISTINCT COUNT(*) 'students' FROM exams WHERE subjectid = '$subjectid'";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        $num_students = $row['students'];
    
        $query = "SELECT AVG(nota) AS 'avg_grade', MIN(nota) AS 'min_grade', MAX(nota) AS 'max_grade' FROM exams WHERE subjectid = '$subjectid'";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        $avg_grade = number_format($row['avg_grade'],2);
        $min_grade = number_format($row['min_grade'],2);
        $max_grade = number_format($row['max_grade'],2);
    
        $query = "SELECT COUNT(nota) AS 'grade_f' FROM exams WHERE subjectid = '$subjectid' AND nota<5";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        $grade_f = $row['grade_f'];
    
        $query = "SELECT COUNT(nota) AS 'grade_c' FROM exams WHERE subjectid = '$subjectid' AND nota>=5 AND nota<=6";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        $grade_c = $row['grade_c'];
    
        $query = "SELECT COUNT(nota) AS 'grade_b' FROM exams WHERE subjectid = '$subjectid' AND nota>=7 AND nota<=8";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        $grade_b = $row['grade_b'];
    
        $query = "SELECT COUNT(nota) AS 'grade_a' FROM exams WHERE subjectid = '$subjectid' AND nota>=9 AND nota<=10";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        $grade_a = $row['grade_a'];
    
        $html = "<br><h3>Estadísticas de $subject_name ($exam_date):</h3>
        <table>
            <tr>
                <th>Total alumnos</th>
                <th>Nota media</th>
                <th>Nota mínima</th>
                <th>Nota máxima</th>
                <th>Suspensos</th>
                <th>Aprobados</th>
                <th>Notables</th>
                <th>Sobresalientes</th>
            </tr>
            <tr>
                <td>$num_students</td>
                <td>$avg_grade</td>
                <td>$min_grade</td>
                <td>$max_grade</td>
                <td>$grade_f</td>
                <td>$grade_c</td>
                <td>$grade_b</td>
                <td>$grade_a</td>
            </tr>
        </table>
        <br><hr><br>
        <table>
            <tr>
                <th>Nombre y apellidos</th>
                <th>Nota</th>
            </tr>";
    
        $query = "SELECT U.name, U.surname, E.nota, E.date FROM exams E, users U WHERE E.subjectid = '$subjectid' AND E.uid = U.uid ORDER BY U.name";
        $result = mysqli_query($db,$query);
    
        while($row = $result->fetch_assoc())
        {
            $grade = $row['nota'] == NULL ? "No presentado" : $row['nota'];
    
            $html.= "<tr>
            <td>".$row['name'].", ".$row['surname']." </td>
            <td>$grade</td>
            </tr>";
        }
    
        $html.="</table><br>";
    
        echo $html;
    }

?>