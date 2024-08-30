Game Name: Kids' World of Fun

Installation process:

- Download the game dw3.zip file. 
- Unzip it in the 'www' folder inside the 'wamp64' folder in your local disk. The file path should be:
C:\wamp64\www
- Go to your browser and enter the following path: 
http://localhost/dw3/index.php
- In the home page, click the 'Sign up' at the header and proceed to create a new account. Once the account has been successfully created, you can log in and start the game. Feel free to explore the website.

1. The full name of the developers (teammates of the team) and the contribution of each to the developed program.

# Developer: Huynh Tu Anh Chau
- Creation of user accounts or registration (Sign-Up).
- Real-time validation of information entered by the user in the user account creation form with AJAX.
- Login to an existing user account (Sign-In).
- Disconnect from a connected user account (Sign-Out and Time-Out).

- Creation of the structure to create and exchange data with the database.
- Changing the password of an existing user account.
- Creation of the structure of web pages to display (e.g., head, header, nav, footer).
- Display of the history of the results of all game rounds.

- Management of several levels of a question/answer game which follow one another.
- Abandoning a game in progress.
- Customized display of features and addition of additional interactivity and attraction features.
- About page and Interesting stuffs for navigation

- Creation and implementation of the GitHub account.
- Creation of the structure of folders and files.
- Management of several levels of a question/answer game which follow one another.
- Coordination of the integration of different functionalities.

2. The game's release date

April 12, 2024

3. Enumeration and description of all features of the Website (see section 1), including additional features added

User Account Management: Registration, login, logout, and password reset functionalities.
Real-time Form Validation: Using AJAX for immediate feedback in the registration and login forms.
Multi-Level Game: Various levels of question-and-answer gameplay, each with increasing difficulty.
Game History: Retrieve data from MySQL and display the gaming history of all players.
Database Interaction: Utilizes MySQL for storing and retrieving user and game data.

4. How the game works, such as the description of levels and the number of lives allocated.

The player starts with 6 lives. Every time the player submits a wrong answer in any level of the game, one life is reduced. Once the player has used all the lives and hasn't succeeded all 6 levels, a message will be displayed and the player will be prompted to try again. This game match will be saved as 'gameover'. If the player successfully wins the game, a message will be displayed and the player can choose to play again. This game match will be saved as 'win'. If the player chooses to abandon the game, it will be saved as 'incomplete' if they still have remaining lives.

# Level 1: Arrange 6 letters in ascending order
The player will be given 6 random letters, in which they have to arrange it in ascending order by seperating each letter in a space or comma.

# Level 2: Arrange 6 letters in descending order
The player will be given 6 random letters, in which they have to arrange it in descending order by seperating each letter in a space or comma.

# Level 3: Arrange 6 numbers in ascending order
The player will be given 6 random numbers, in which they have to arrange it in ascending order by seperating each number in a space or comma.

# Level 4: Arrange 6 numbers in descending order
The player will be given 6 random numbers, in which they have to arrange it in descending order by seperating each number in a space or comma.

# Level 5: Write only the smallest letter and the largest letter in a set of 6 letters
The player will be given 6 random letters, in which they have to enter only the smallest and the largest letter and seperate it in a space or comma.

# Level 6: Write only the smallest number and the largest number in a set of 6 numbers
The player will be given 6 random numbers, in which they have to enter only the smallest and the largest number and seperate it in a space or comma.

The letters and numbers in each game are randomly generated. With a quantity of 6, the letters can vary from a to z and the numbers can vary from 0 to 100.

5. Any other relevant technical information on the program developed, including the programming languages and database management system used, their version and other relevant information.

Programming language used: PHP 8.2.13
Database Management System: MySQL 8.2.0
Other: AJAX, JavaScript, HTML, CSS
