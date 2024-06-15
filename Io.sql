 
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    name VARCHAR(255) NOT NULL,
    description TEXT,
    budget DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE incomes (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    amount DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE outcomes (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    category_id INTEGER REFERENCES categories(id),
    amount DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE sessions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    token MEDIUMTEXT NOT NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


/* some fake data to try */

INSERT INTO categories (user_id, name, description, budget) VALUES (1, 'Food', 'Groceries and eating out', 500.00);
INSERT INTO categories (user_id, name, description, budget) VALUES (1, 'Transportation', 'Gas and public transportation', 200.00);
INSERT INTO categories (user_id, name, description, budget) VALUES (1, 'Entertainment', 'Movies, concerts, and events', 100.00);

INSERT INTO incomes (user_id, amount, date, description) VALUES (1, 2000.00, '2020-01-01', 'January salary');
INSERT INTO incomes (user_id, amount, date, description) VALUES (1, 1500.00, '2020-02-01', 'February salary');
INSERT INTO incomes (user_id, amount, date, description) VALUES (1, 1800.00, '2020-03-01', 'March salary');

INSERT INTO outcomes (user_id, category_id, amount, date, description) VALUES (1, 1, 100.00, '2020-01-05', 'Groceries');
INSERT INTO outcomes (user_id, category_id, amount, date, description) VALUES (1, 1, 50.00, '2020-01-10', 'Eating out');
INSERT INTO outcomes (user_id, category_id, amount, date, description) VALUES (1, 2, 40.00, '2020-01-15', 'Gas');



