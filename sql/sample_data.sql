
INSERT INTO users (id, name, email, password_hash, role) VALUES
(1, 'Sample Seller One', 'seller1@example.com', 'PLACEHOLDER_NOT_A_REAL_HASH', 'user'),
(2, 'Sample Seller Two', 'seller2@example.com', 'PLACEHOLDER_NOT_A_REAL_HASH', 'user');


INSERT INTO listings (id, seller_id, category_id, title, description, price, item_condition) VALUES
(1, 1, 2, 'Introduction to Algorithms Book', 'Used for one semester. No missing pages.', 800.00, 'good'),
(2, 1, 5, 'Casio Scientific Calculator', 'Works perfectly. Small scratch on the back.', 600.00, 'like_new'),
(3, 2, 3, 'CSE 1st Semester Class Notes', 'Handwritten and neatly organized notes.', 150.00, 'good'),
(4, 2, 1, 'Physics Textbook', 'Some highlighted lines inside.', 400.00, 'fair'),
(5, 2, 6, 'Wireless Mouse', 'Used for six months. Battery included.', 350.00, 'good');


INSERT INTO courses (id, department, semester, course_code, course_name) VALUES
(1, 'CSE', '1st', 'CSE101', 'Programming Fundamentals'),
(2, 'CSE', '2nd', 'CSE201', 'Data Structures and Algorithms'),
(3, 'CSE', '1st', 'PHY101', 'Physics');

INSERT INTO course_listings (course_id, listing_id) VALUES
(1, 3),
(2, 1),
(3, 4);


INSERT INTO favorites (user_id, listing_id) VALUES (1, 3);
INSERT INTO reports (listing_id, reporter_id, reason) VALUES (5, 1, 'Test report: price looks unusual');