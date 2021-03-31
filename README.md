# Web system for managing online exams 👨‍🏫📚


### The general idea is that each teacher could create a question set oh his subjects. Each question is associated to a unit of the subject. When de question set of the subject is completed, the system will be available for students to take the exam.

## Some considerations:

1. The center is divided in diferent degrees, for example, the ESI (Escuela Superior de Ingeniería) has the Science Ingenieering, Aerospacial Ingenieering among others
2. Each degree has diferent subjects
3. Each subject has diferent units, and each unit has some posible questions.
4. Each subject just have one coordinator teacher, but a teacher could be the coordinator of some subjects
5. A student could enroll in some subjects

## As is obviously, the system will have three diferent rols: teachers, students and admins. 
## The use cases are:
1. Access control system: each rol will have their own menu
2. Teacher menu: 
* Questions management: The teacher could select one of his subjects and create, read, update or delete (CRUD) questions. Each question is associated to a unit and they will have to introduce both the text and the possible answers. The correct answer will be saved too.
* Results management: After the exam date, the teacher could see the results of their students, it means, the calification from each of them, the number of failed, passed and outstanding exams, and finally the average mark of this exam.
3. Student menu: 
* Take exams: The exam day of each subject, the enroll students will be access to the exam. This exam will be generated automaticaly by the system, choosing randomly some questions of each unit of the subject.
* Marks display: When the student answer the questions, their questions will be stored on the data base and the system will correct automaticaly the exam, showing students mark and the failed answers. Obviously, the student could see this information when they need, so, it will be stored on the database.
4. Admin menu: 
* Users and subjects management: The admin will be able to create, edit, update or delete system users and subjects.
