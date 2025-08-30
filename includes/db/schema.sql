CREATE DATABASE vktsr;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,          
    userid VARCHAR(255) UNIQUE NOT NULL,        -- Make sure userid is UNIQUE
    name VARCHAR(255) NOT NULL,                 
    phone_number VARCHAR(15) UNIQUE,            
    email VARCHAR(255) UNIQUE NOT NULL,         
    password VARCHAR(255) NOT NULL,             
    referral_code VARCHAR(255) UNIQUE,          
    referred_by VARCHAR(255),                   
    level ENUM('L1', 'L2', 'Premium') DEFAULT 'L1',
    referral_count INT DEFAULT 0,               
    referral_count_inactive INT DEFAULT 0,      
    status INT DEFAULT 0,                        
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Unique identifier for the user 
    name VARCHAR(100) NOT NULL,                   -- Full name of the user
    phone_number VARCHAR(15) UNIQUE,              -- Phone number of the user
    email VARCHAR(255) UNIQUE,                    -- Email address
    password VARCHAR(255) NOT NULL,               -- Hashed password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp when the user was created
);

CREATE TABLE wallet (
    id INT AUTO_INCREMENT PRIMARY KEY,            
    userid VARCHAR(255) NOT NULL,                  -- Match the data type with users.userid
    deposit DECIMAL(10, 2) DEFAULT 0.00,          
    withdraw DECIMAL(10, 2) DEFAULT 0.00,         
    bonus DECIMAL(10, 2) DEFAULT 0.00,            
    FOREIGN KEY (userid) REFERENCES users(userid) -- Reference the UNIQUE userid in users table
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Unique identifier for the transaction
    transaction_id VARCHAR(50) NOT NULL UNIQUE,   -- Unique transaction identifier
    userid VARCHAR(50) NOT NULL,                  -- User's unique identifier (foreign key reference)
    type ENUM('deposit', 'withdraw', 'bonus', 'commission') NOT NULL, -- Type of transaction
    amount DECIMAL(10, 2) NOT NULL,               -- Transaction amount
    from_wallet ENUM('deposit', 'withdraw', 'bonus') NOT NULL, -- Source wallet
    status ENUM('pending', 'failed', 'success') NOT NULL, -- Transaction status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when the transaction was created
    FOREIGN KEY (userid) REFERENCES users(userid)  -- Foreign key linking to the user table
);


-- lottery

CREATE TABLE lottery_types (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique lottery type ID
    name VARCHAR(50) NOT NULL UNIQUE,         -- Lottery name (e.g., "10", "20", "50")
    description TEXT,                         -- Description of the lottery type
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp for when the type was created
);

CREATE TABLE lotteries (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique lottery ID
    lottery_type_id INT NOT NULL,             -- Foreign key to lottery_types
    date DATE NOT NULL,                       -- Date of the lottery
    period ENUM('daily', 'weekly') NOT NULL,  -- Type of period (daily/weekly)
    status ENUM('open', 'closed') DEFAULT 'open', -- Lottery status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Lottery creation timestamp
    FOREIGN KEY (lottery_type_id) REFERENCES lottery_types(id)
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique ticket ID
    user_id INT NOT NULL,                     -- Foreign key to users
    lottery_id INT NOT NULL,                  -- Foreign key to lotteries
    ticket_number VARCHAR(20) NOT NULL,       -- Unique ticket number
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for ticket purchase
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lottery_id) REFERENCES lotteries(id)
);


CREATE TABLE winners (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique winner record ID
    lottery_id INT NOT NULL,                  -- Foreign key to lotteries
    user_id INT NOT NULL,                     -- Foreign key to users
    prize_amount DECIMAL(10, 2) NOT NULL,     -- Amount won by the user
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for winner record
    FOREIGN KEY (lottery_id) REFERENCES lotteries(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- ROI

CREATE TABLE plans (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Unique ID for the plan
    product_name VARCHAR(255) NOT NULL,         -- Plan name
    price DECIMAL(10, 2) NOT NULL,              -- Price of the plan
    daily_income DECIMAL(10, 2) NOT NULL,       -- Daily income from the plan
    days INT NOT NULL,                          -- Duration of the plan in days
    total_revenue DECIMAL(10, 2) NOT NULL,      -- Total revenue = daily_income * days
    invitation_commission DECIMAL(10, 2),       -- Commission for referring others
    rate_of_return DECIMAL(5, 2) NOT NULL,      -- Rate of return as a percentage
    purchase_limit INT DEFAULT NULL,            -- Maximum times a user can purchase
    level ENUM('L1', 'L2', 'Premium', 'Weekly') NOT NULL, -- Plan level
    rules TEXT DEFAULT NULL                     -- Additional rules in JSON format
);

CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Unique purchase ID
    user_id INT NOT NULL,                       -- ID of the user making the purchase
    plan_id INT NOT NULL,                       -- ID of the purchased plan
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- When the purchase was made
    expiry_date TIMESTAMP NULL DEFAULT NULL,    -- Date when the plan expires
    daily_earnings DECIMAL(10, 2) NOT NULL,     -- Earnings per day from this purchase
    total_earned DECIMAL(10, 2) DEFAULT 0.00,   -- Total earned from this plan
    status ENUM('active', 'completed') DEFAULT 'active', -- Plan status
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (plan_id) REFERENCES plans(id)
);


CREATE TABLE daily_referral_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique log ID
    referrer_id INT NOT NULL,                  -- User who made the referral
    referred_id INT NOT NULL,                  -- User who was referred
    referral_date DATE NOT NULL,               -- Date of the referral
    FOREIGN KEY (referrer_id) REFERENCES users(id),
    FOREIGN KEY (referred_id) REFERENCES users(id)
);

CREATE TABLE daily_referral_contests (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique contest ID
    contest_date DATE NOT NULL,               -- Date of the contest (YYYY-MM-DD)
    user_id INT NOT NULL,                     -- User who referred the most people on that day
    referral_count INT NOT NULL,              -- Number of referrals made by the user
    prize DECIMAL(10, 2) NOT NULL,            -- Prize for the winner
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- When the contest was created
    FOREIGN KEY (user_id) REFERENCES users(id)
);


ALTER TABLE plans 
ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active' AFTER rules;

ALTER TABLE lotteries
ADD COLUMN lottery_amount DECIMAL(10, 2) NOT NULL AFTER period,
ADD COLUMN return_amount DECIMAL(10, 2) DEFAULT NULL AFTER lottery_amount;

ALTER TABLE transactions 
MODIFY type ENUM('deposit', 'withdraw', 'bonus', 'commission', 'lottery_winning', 'daily_earnings', 'plan_maturity_bonus') NOT NULL;
ALTER TABLE transactions 
ADD notes TEXT DEFAULT NULL AFTER status;


ALTER TABLE users 
ADD address TEXT DEFAULT NULL AFTER email;



CREATE TABLE banks (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Unique identifier for the bank
    name VARCHAR(255) NOT NULL,                    -- Full name of the bank
    nickname VARCHAR(100) NOT NULL,                -- Short nickname for the bank
    limit DECIMAL(10, 2) NOT NULL,                 -- Withdrawal limit for the bank
    image VARCHAR(255),                            -- Image of the bank or bank logo
    upi_id VARCHAR(50) NOT NULL,                   -- UPI ID for the bank
    status ENUM('active', 'inactive') DEFAULT 'active', -- Bank status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp when the bank entry is created
);

CREATE TABLE deposits (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Unique identifier for the deposit
    userid INT NOT NULL,                          -- User ID (foreign key to users table)
    bank_id INT NOT NULL,                         -- Bank ID (foreign key to banks table)
    utr_number VARCHAR(50) NOT NULL,              -- Unique transaction reference (UTR) number
    bank_name VARCHAR(255) NOT NULL,              -- Bank name
    amount DECIMAL(10, 2) NOT NULL,               -- Deposit amount
    transaction_id VARCHAR(50) NOT NULL,          -- Transaction ID
    image VARCHAR(255),                           -- Image file (e.g., screenshot of the transaction)
    status ENUM('pending', 'success', 'failed') DEFAULT 'pending', -- Transaction status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when the deposit is created
    FOREIGN KEY (userid) REFERENCES users(id),    -- Foreign key linking to the users table
    FOREIGN KEY (bank_id) REFERENCES banks(id)    -- Foreign key linking to the banks table
);


CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Unique identifier for the withdrawal
    userid INT NOT NULL,                          -- User ID (foreign key to users table)
    bank_account_name VARCHAR(255) NOT NULL,      -- Bank account name
    bank_account_number VARCHAR(50) NOT NULL,     -- Bank account number
    bank_name VARCHAR(255) NOT NULL,              -- Bank name
    ifsc_code VARCHAR(20) NOT NULL,               -- IFSC code for the bank
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when the withdrawal is created
    FOREIGN KEY (userid) REFERENCES users(id)     -- Foreign key linking to the users table
);

ALTER TABLE `plans` ADD `bonus` FLOAT NOT NULL AFTER `days`;
ALTER TABLE `lottery_types` ADD `ticket` FLOAT NOT NULL AFTER `name`, ADD `winning` FLOAT NOT NULL AFTER `ticket`;
ALTER TABLE `lottery_types` ADD `type` ENUM('Daily','Weekly') NOT NULL AFTER `winning`;
ALTER TABLE `lottery_types` CHANGE `type` `type` ENUM('Daily','Weekly') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Daily';
ALTER TABLE `lottery_types` ADD `status` ENUM('active','inactive') NOT NULL DEFAULT 'active' AFTER `created_at`;


CREATE TABLE schemes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    scheme_name VARCHAR(255) NOT NULL,
    number_of_refers INT NOT NULL DEFAULT 0,
    winning_prize TEXT NOT NULL,
    scheme_type ENUM('Direct', 'Indirect') NOT NULL DEFAULT 'Direct',
    description TEXT,
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE withdraws (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    accounts_id INT  NOT NULL,
    transaction_id VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'success', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(userid),
    FOREIGN KEY (accounts_id) REFERENCES accounts(id) 
) ENGINE=InnoDB;

ALTER TABLE `banks` ADD `used_limit` FLOAT NOT NULL AFTER `acc_limit`;

ALTER TABLE `users` CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
ALTER TABLE `tickets` ADD `status` ENUM('open','closed') NOT NULL AFTER `created_at`;
ALTER TABLE `transactions` CHANGE `type` `type` ENUM('deposit','withdraw','bonus','commission','lottery_winning','daily_earnings','plan_maturity_bonus','plan_buy','lottery_buy') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
