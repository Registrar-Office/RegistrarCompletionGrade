<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Web Technology Track Curriculum
        $webTechCurriculum = [
            // First Year
            ['major' => 'Web Technology Track', 'subject_code' => 'GE101', 'subject_name' => 'Understanding the Self', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'GE102', 'subject_name' => 'Readings in Philippine History', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'CS101', 'subject_name' => 'Introduction to Computing', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'MATH101', 'subject_name' => 'College Algebra', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'ENG101', 'subject_name' => 'Purposive Communication', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'PE101', 'subject_name' => 'Physical Education 1', 'year' => 1, 'trimester' => 1, 'units' => 2, 'prerequisite' => null],

            ['major' => 'Web Technology Track', 'subject_code' => 'GE103', 'subject_name' => 'The Contemporary World', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'GE104', 'subject_name' => 'Mathematics in the Modern World', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'CS102', 'subject_name' => 'Computer Programming 1', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'CS101'],
            ['major' => 'Web Technology Track', 'subject_code' => 'MATH102', 'subject_name' => 'Trigonometry', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'MATH101'],
            ['major' => 'Web Technology Track', 'subject_code' => 'ENG102', 'subject_name' => 'Technical Writing', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'ENG101'],
            ['major' => 'Web Technology Track', 'subject_code' => 'PE102', 'subject_name' => 'Physical Education 2', 'year' => 1, 'trimester' => 2, 'units' => 2, 'prerequisite' => 'PE101'],

            ['major' => 'Web Technology Track', 'subject_code' => 'GE105', 'subject_name' => 'Science, Technology and Society', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'GE106', 'subject_name' => 'Art Appreciation', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'CS103', 'subject_name' => 'Computer Programming 2', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'CS102'],
            ['major' => 'Web Technology Track', 'subject_code' => 'MATH103', 'subject_name' => 'Calculus 1', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'MATH102'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT101', 'subject_name' => 'Web Design Fundamentals', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'PE103', 'subject_name' => 'Physical Education 3', 'year' => 1, 'trimester' => 3, 'units' => 2, 'prerequisite' => 'PE102'],

            // Second Year
            ['major' => 'Web Technology Track', 'subject_code' => 'GE107', 'subject_name' => 'Ethics', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'CS201', 'subject_name' => 'Data Structures and Algorithms', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'CS103'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT201', 'subject_name' => 'Web Programming 1', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT101'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT202', 'subject_name' => 'Database Management Systems', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'CS103'],
            ['major' => 'Web Technology Track', 'subject_code' => 'MATH201', 'subject_name' => 'Discrete Mathematics', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'MATH103'],
            ['major' => 'Web Technology Track', 'subject_code' => 'PE104', 'subject_name' => 'Physical Education 4', 'year' => 2, 'trimester' => 1, 'units' => 2, 'prerequisite' => 'PE103'],

            ['major' => 'Web Technology Track', 'subject_code' => 'GE108', 'subject_name' => 'Rizal\'s Life and Works', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'CS202', 'subject_name' => 'Object-Oriented Programming', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'CS201'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT203', 'subject_name' => 'Web Programming 2', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT201'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT204', 'subject_name' => 'Human Computer Interaction', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT201'],
            ['major' => 'Web Technology Track', 'subject_code' => 'STAT201', 'subject_name' => 'Statistics and Probability', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'MATH201'],
            ['major' => 'Web Technology Track', 'subject_code' => 'NSTP101', 'subject_name' => 'NSTP 1', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],

            ['major' => 'Web Technology Track', 'subject_code' => 'GE109', 'subject_name' => 'Filipino sa Iba\'t Ibang Disiplina', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'CS203', 'subject_name' => 'Software Engineering 1', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'CS202'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT205', 'subject_name' => 'Web Framework Development', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT203'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT206', 'subject_name' => 'Systems Analysis and Design', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT204'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT207', 'subject_name' => 'Web Graphics and Multimedia', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT204'],
            ['major' => 'Web Technology Track', 'subject_code' => 'NSTP102', 'subject_name' => 'NSTP 2', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'NSTP101'],

            // Third Year
            ['major' => 'Web Technology Track', 'subject_code' => 'CS301', 'subject_name' => 'Software Engineering 2', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'CS203'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT301', 'subject_name' => 'Advanced Web Development', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT205'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT302', 'subject_name' => 'Mobile Web Development', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT205'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT303', 'subject_name' => 'Web Security', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT206'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT304', 'subject_name' => 'E-Commerce Development', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT205'],
            ['major' => 'Web Technology Track', 'subject_code' => 'ELX301', 'subject_name' => 'Professional Elective 1', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],

            ['major' => 'Web Technology Track', 'subject_code' => 'CS302', 'subject_name' => 'Computer Networks', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'CS301'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT305', 'subject_name' => 'Web API Development', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT301'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT306', 'subject_name' => 'Content Management Systems', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT301'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT307', 'subject_name' => 'Web Performance Optimization', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT302'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT308', 'subject_name' => 'Database Administration', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT202'],
            ['major' => 'Web Technology Track', 'subject_code' => 'ELX302', 'subject_name' => 'Professional Elective 2', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],

            ['major' => 'Web Technology Track', 'subject_code' => 'IT309', 'subject_name' => 'Capstone Project 1', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT305'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT310', 'subject_name' => 'Web Testing and Quality Assurance', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT307'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT311', 'subject_name' => 'Cloud Computing for Web', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT308'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT312', 'subject_name' => 'DevOps for Web Development', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT310'],
            ['major' => 'Web Technology Track', 'subject_code' => 'PRAC301', 'subject_name' => 'Practicum (120 hours)', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT309'],
            ['major' => 'Web Technology Track', 'subject_code' => 'ELX303', 'subject_name' => 'Professional Elective 3', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],

            // Fourth Year (NO TRIMESTER SYSTEM - single year for OJT/Internship)
            ['major' => 'Web Technology Track', 'subject_code' => 'IT401', 'subject_name' => 'Capstone Project 2', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => 'IT309'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT402', 'subject_name' => 'Emerging Web Technologies', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => 'IT311'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT403', 'subject_name' => 'Web Analytics and SEO', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => 'IT312'],
            ['major' => 'Web Technology Track', 'subject_code' => 'IT404', 'subject_name' => 'Professional Issues in IT', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Web Technology Track', 'subject_code' => 'OJT401', 'subject_name' => 'On-the-Job Training (480 hours)', 'year' => 4, 'trimester' => null, 'units' => 6, 'prerequisite' => 'IT401'],
        ];

        // Network Security Track Curriculum
        $netSecCurriculum = [
            // First Year (Same as Web Tech for general subjects)
            ['major' => 'Network Security Track', 'subject_code' => 'GE101', 'subject_name' => 'Understanding the Self', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'GE102', 'subject_name' => 'Readings in Philippine History', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'CS101', 'subject_name' => 'Introduction to Computing', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'MATH101', 'subject_name' => 'College Algebra', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'ENG101', 'subject_name' => 'Purposive Communication', 'year' => 1, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'PE101', 'subject_name' => 'Physical Education 1', 'year' => 1, 'trimester' => 1, 'units' => 2, 'prerequisite' => null],

            ['major' => 'Network Security Track', 'subject_code' => 'GE103', 'subject_name' => 'The Contemporary World', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'GE104', 'subject_name' => 'Mathematics in the Modern World', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'CS102', 'subject_name' => 'Computer Programming 1', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'CS101'],
            ['major' => 'Network Security Track', 'subject_code' => 'MATH102', 'subject_name' => 'Trigonometry', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'MATH101'],
            ['major' => 'Network Security Track', 'subject_code' => 'ENG102', 'subject_name' => 'Technical Writing', 'year' => 1, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'ENG101'],
            ['major' => 'Network Security Track', 'subject_code' => 'PE102', 'subject_name' => 'Physical Education 2', 'year' => 1, 'trimester' => 2, 'units' => 2, 'prerequisite' => 'PE101'],

            ['major' => 'Network Security Track', 'subject_code' => 'GE105', 'subject_name' => 'Science, Technology and Society', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'GE106', 'subject_name' => 'Art Appreciation', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'CS103', 'subject_name' => 'Computer Programming 2', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'CS102'],
            ['major' => 'Network Security Track', 'subject_code' => 'MATH103', 'subject_name' => 'Calculus 1', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'MATH102'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT101', 'subject_name' => 'Introduction to Cybersecurity', 'year' => 1, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'PE103', 'subject_name' => 'Physical Education 3', 'year' => 1, 'trimester' => 3, 'units' => 2, 'prerequisite' => 'PE102'],

            // Second Year
            ['major' => 'Network Security Track', 'subject_code' => 'GE107', 'subject_name' => 'Ethics', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'CS201', 'subject_name' => 'Data Structures and Algorithms', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'CS103'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT201', 'subject_name' => 'Network Fundamentals', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT101'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT202', 'subject_name' => 'Database Management Systems', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'CS103'],
            ['major' => 'Network Security Track', 'subject_code' => 'MATH201', 'subject_name' => 'Discrete Mathematics', 'year' => 2, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'MATH103'],
            ['major' => 'Network Security Track', 'subject_code' => 'PE104', 'subject_name' => 'Physical Education 4', 'year' => 2, 'trimester' => 1, 'units' => 2, 'prerequisite' => 'PE103'],

            ['major' => 'Network Security Track', 'subject_code' => 'GE108', 'subject_name' => 'Rizal\'s Life and Works', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'CS202', 'subject_name' => 'Object-Oriented Programming', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'CS201'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT203', 'subject_name' => 'Network Security Fundamentals', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT201'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT204', 'subject_name' => 'Operating Systems Security', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT201'],
            ['major' => 'Network Security Track', 'subject_code' => 'STAT201', 'subject_name' => 'Statistics and Probability', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'MATH201'],
            ['major' => 'Network Security Track', 'subject_code' => 'NSTP101', 'subject_name' => 'NSTP 1', 'year' => 2, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],

            ['major' => 'Network Security Track', 'subject_code' => 'GE109', 'subject_name' => 'Filipino sa Iba\'t Ibang Disiplina', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'CS203', 'subject_name' => 'Software Engineering 1', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'CS202'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT205', 'subject_name' => 'Cryptography', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT203'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT206', 'subject_name' => 'Ethical Hacking and Penetration Testing', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT204'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT207', 'subject_name' => 'Digital Forensics', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT204'],
            ['major' => 'Network Security Track', 'subject_code' => 'NSTP102', 'subject_name' => 'NSTP 2', 'year' => 2, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'NSTP101'],

            // Third Year
            ['major' => 'Network Security Track', 'subject_code' => 'CS301', 'subject_name' => 'Software Engineering 2', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'CS203'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT301', 'subject_name' => 'Advanced Network Security', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT205'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT302', 'subject_name' => 'Wireless Network Security', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT205'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT303', 'subject_name' => 'Incident Response and Recovery', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT206'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT304', 'subject_name' => 'Malware Analysis', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => 'IT207'],
            ['major' => 'Network Security Track', 'subject_code' => 'ELX301', 'subject_name' => 'Professional Elective 1', 'year' => 3, 'trimester' => 1, 'units' => 3, 'prerequisite' => null],

            ['major' => 'Network Security Track', 'subject_code' => 'CS302', 'subject_name' => 'Computer Networks', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'CS301'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT305', 'subject_name' => 'Security Risk Assessment', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT301'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT306', 'subject_name' => 'Cloud Security', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT301'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT307', 'subject_name' => 'Mobile Device Security', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT302'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT308', 'subject_name' => 'Security Policies and Procedures', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => 'IT303'],
            ['major' => 'Network Security Track', 'subject_code' => 'ELX302', 'subject_name' => 'Professional Elective 2', 'year' => 3, 'trimester' => 2, 'units' => 3, 'prerequisite' => null],

            ['major' => 'Network Security Track', 'subject_code' => 'IT309', 'subject_name' => 'Capstone Project 1', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT305'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT310', 'subject_name' => 'Security Audit and Compliance', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT308'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT311', 'subject_name' => 'Advanced Cryptography', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT306'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT312', 'subject_name' => 'Security Architecture and Design', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT307'],
            ['major' => 'Network Security Track', 'subject_code' => 'PRAC301', 'subject_name' => 'Practicum (120 hours)', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => 'IT309'],
            ['major' => 'Network Security Track', 'subject_code' => 'ELX303', 'subject_name' => 'Professional Elective 3', 'year' => 3, 'trimester' => 3, 'units' => 3, 'prerequisite' => null],

            // Fourth Year (NO TRIMESTER SYSTEM - single year for OJT/Internship)
            ['major' => 'Network Security Track', 'subject_code' => 'IT401', 'subject_name' => 'Capstone Project 2', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => 'IT309'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT402', 'subject_name' => 'Emerging Security Technologies', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => 'IT311'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT403', 'subject_name' => 'Security Management and Leadership', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => 'IT312'],
            ['major' => 'Network Security Track', 'subject_code' => 'IT404', 'subject_name' => 'Professional Issues in IT', 'year' => 4, 'trimester' => null, 'units' => 3, 'prerequisite' => null],
            ['major' => 'Network Security Track', 'subject_code' => 'OJT401', 'subject_name' => 'On-the-Job Training (480 hours)', 'year' => 4, 'trimester' => null, 'units' => 6, 'prerequisite' => 'IT401'],
        ];

        // Insert all curriculum data and ensure all courses exist
        $allCurriculum = array_merge($webTechCurriculum, $netSecCurriculum);
        foreach ($allCurriculum as $curriculum) {
            Curriculum::create($curriculum);
            // Ensure a Course exists for each subject_code
            Course::firstOrCreate(
                ['code' => $curriculum['subject_code']],
                [
                    'title' => $curriculum['subject_name'],
                    'instructor_name' => 'TBA', // Default placeholder
                    'college' => 'TBA' // Default placeholder
                ]
            );
        }
    }
}
