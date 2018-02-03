delete from ebh_roomusers where crid not in (select crid from ebh_classrooms);
delete from ebh_roomusers where uid not in (select memberid from ebh_members);
delete from ebh_roomteachers where crid not in (select crid from ebh_classrooms);
delete from ebh_roomteachers where tid not in (select teacherid from ebh_teachers);


create table temptable as (select * from ebh_classstudents where (classid,uid) not in(
select cs.classid,cs.uid from ebh_roomusers r 
join ebh_classes cl on cl.crid=r.crid 
join ebh_classstudents cs on cs.classid=cl.classid 
where r.uid = cs.uid));
delete from ebh_classstudents where (classid,uid) in (select classid,uid from temptable);
drop table temptable;

create table temptable as (select * from ebh_classteachers where (classid,uid) not in(
select cs.classid,cs.uid from ebh_roomteachers r 
join ebh_classes cl on cl.crid=r.crid 
join ebh_classteachers cs on cs.classid=cl.classid 
where r.tid = cs.uid));
delete from ebh_classteachers where (classid,uid) in (select classid,uid from temptable);
drop table temptable;

create table temptable as (select * from ebh_teacherfolders where (crid,tid,folderid) not in (select tf.crid,tf.tid,tf.folderid from ebh_roomteachers r 
join ebh_folders f on f.crid=r.crid
join ebh_teacherfolders tf on tf.folderid=f.folderid
where r.tid=tf.tid));
delete from ebh_teacherfolders where (crid,tid,folderid) in (select crid,tid,folderid from temptable);
drop table temptable;

update ebh_classrooms c left join ebh_roomteachers r on c.crid=r.crid
set c.teanum = (select count(*) from ebh_roomteachers where crid=c.crid);

update ebh_classrooms c left join ebh_roomusers r on c.crid=r.crid
set c.stunum = (select count(*) from ebh_roomusers where crid=c.crid);

update ebh_classes c left join ebh_classstudents cs on c.classid=cs.classid
set c.stunum = (select count(*) from ebh_classstudents where classid=c.classid);

update ebh_classrooms c left join ebh_schexams e on c.crid=e.crid
set c.examcount = (select count(*) from ebh_schexams where crid=c.crid) where c.isschool in (3,6);

update ebh_classrooms c left join ebh_exams e on c.crid=e.crid
set c.examcount = (select count(*) from ebh_exams where crid=c.crid) where c.isschool not in (3,6);

//课程人气
update ebh_folders f left join ebh_roomcourses rc on (f.crid=rc.crid and f.folderid=rc.folderid)
set f.viewnum = (
select ifnull(sum(viewnum),0) from ebh_coursewares c 
join ebh_roomcourses rc on (c.cwid=rc.cwid)
where f.crid=rc.crid and f.folderid=rc.folderid
);

//课程课件数
update ebh_folders f left join ebh_roomcourses rc on (f.crid=rc.crid and f.folderid =rc.folderid)
set f.coursewarenum = (select count(*) from ebh_roomcourses where folderid=f.folderid);

//平台课件数
update ebh_classrooms c left join ebh_roomcourses rc on c.crid=rc.crid
set c.coursenum = (select count(*) from ebh_roomcourses where crid=c.crid);