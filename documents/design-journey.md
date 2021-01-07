# Project 3: Design Journey

Be clear and concise in your writing. Bullets points are encouraged.

**Everything, including images, must be visible in VS Code's Markdown Preview.** If it's not visible in Markdown Preview, then we won't grade it.

# Design & Plan (Milestone 2)

**The gallery appears after one make a donation of artwork in the donation page. After donating an artwork successfully, all artwork appears.**

# Design & Plan (Milestone 1)

## Describe your Gallery (Milestone 1)
> What will your gallery be about? 1 sentence.

Artworks made by high school students and local artists.

> Will you be using your existing Project 1 or Project 2 site for this project? If yes, which project?

Project 1

> If using your existing Project 1 or Project 2, please upload sketches of your final design here.

**final website**
![finalDesign](https://media.github.coecis.cornell.edu/user/7833/files/e2242980-8c04-11ea-98b4-ece4622f6082)


## Target Audience(s) (Milestone 1)
> Tell us about your target audience(s).

- audience 1: People who wants to buy artworks and make world a better place
- audience 2: People who would like to donate artworks

## Design Process (Milestone 1)
> Document your design process. Show us the evolution of your design from your first idea (sketch) to design you wish to implement (sketch). Show us the process you used to organize content and plan the navigation (card sorting), if applicable.
> Label all images. All labels must be visible in VS Code's Markdown Preview.
> Clearly label the final design.

**current website**
![currentDesign](https://media.github.coecis.cornell.edu/user/7833/files/4db49880-7f6f-11ea-906a-66a226834a77)

**final website**
![finalDesign](https://media.github.coecis.cornell.edu/user/7833/files/e2242980-8c04-11ea-98b4-ece4622f6082)

- to add an artwork, one need to go to donation page and make an artwork donation. They will be able to see their artwork displayed in in the conformation page
- to "delete" an artwork, is the same as buying an artwork. One need to fill in the auction form in the donation page.
- to see a certain tag, go to shop page and look at the menu bar. Clicking on it allow people to look specifically at the certain cataglory.

## Design Patterns (Milestone 1)
> Explain how your site leverages existing design patterns for image galleries.
> Identify the parts of your design that leverage existing design patterns and justify their usage.
> Most of your site should leverage existing patterns. If not, fully explain why your design is a special case (you need to have a very good reason here to receive full credit).


**For gallery (Shop page)**
* will be able to like an image by clicking a heart
* will be able to see more about an image clicking the +
* will use a similar patter where a money bag indicates purchasing the artwork
* will be able to click the menu bar to see a certain tag

## Requests (Milestone 1)
> Identify and plan each request you will support in your design.
> List each request that you will need (e.g. view image details, view gallery, etc.)
> For each request, specify the request type (GET or POST), how you will initiate the request: (form or query string param URL), and the HTTP parameters necessary for the request.

Example:

- Request: donate artwork (donation page)
  - Type: POST
  - Params: id _or_ artwork_id,(artworks.id in DB)

- Request: donate money (donation page)
  - Type: POST
  - Params: artworks.action
  - (artworks.id in DB)

- Request: view artwork details (tags on shop page)
  - Type: GET
  - Params: id _or_ artwork_id (artworks.id in DB)

## Database Schema Design (Milestone 1)
> Plan the structure of your database. You may use words or a picture.
> Make sure you include constraints for each field.

> Hint: You probably need `images`, `tags`, and `image_tags` tables.

> Hint: For foreign keys, use the singular name of the table + _id. For example: `image_id` and `tag_id` for the `image_tags` table.


Example:
```
artworks (
id : INTEGER {PK, U, Not, AI}
title : TEXT {NOT NULL}
artist_id : INTEGER {NOT NULL}
display_id: INTEGER {NOT NULL}
estimateValue: INTEGER {NOT NULL}
information: TEXT {NOT NULL}
avaliability: BOOLEAN {NOT NULL}
)

CREATE TABLE members (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    position TEXT NOT NULL,
    bio TEXT,
    funfact TEXT
)
CREATE TABLE auctions(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	artworks_id TEXT NO NULL,
);
```


## Database Query Plan (Milestone 1)
> Plan your database queries. You may use natural language, pseudocode, or SQL.
> Using your request plan above, plan all of the queries you need.

### Donate page

**donate an artwork**
```sql
INSERT INTO documentsDisplayed (id, art_name, art_ext, description) VALUES (1, 'artwork1.jpg', 'jpg', 'wood');
```
**donate money (purchasing an artwork)**
```sql
ec_sql_query($db, "SELECT artworks.id FROM artworks where artworks.title = $artworkNameBuy")->fetchAll(PDO::FETCH_ASSOC);
UPDATE auctions SET availability = FALSE WHERE auctions.artwork_id = $artwork_id; ";
exec_sql_query($db, $sql);
```

### Shop page

**display all available artwroks**
```sql
SELECT * FROM artworks inner join auctions on artworks.id = auctions.artwork_id INNER JOIN members ON members.id = artworks.member_id WHERE (tag LIKE '%' || :search || '%')
```

**display sold artwork**
```sql
SELECT * FROM artworks INNER JOIN auctions on artworks.id = auctions.artwork_id WHERE auctions.availability = FALSE
```


## Code Planning (Milestone 1)
> Plan what top level PHP pages you'll need.

- donation page
- shop page
- other pages are also php but is not the main focus of this project


> Plan what partials you'll need.

**header**
![header](https://media.github.coecis.cornell.edu/user/7833/files/79d11900-7f71-11ea-98a6-55fec0df8ada)
```
<header>

    <nav id="navbar">
        <div class="container">
            <label class="logo">ArtForChange</label>

            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="join.php">JOIN</a></li>
                <li><a href="learn_about_us.php">LEARN ABOUT US</a></li>
                <li><a href="donation.php">DONATION</a></li>
                <li><a href="shop.php">SHOP</a></li>
            </ul>
        </div>
    </nav>
</header>

```
**footer**
![footer](https://media.github.coecis.cornell.edu/user/7833/files/73db3800-7f71-11ea-9b9d-066a2660fa53)

```
<div class="clear"></div>
<footer id="footer-m">
        <p>ArtForChange&copy;2020 contact us @ afcnshs@gmail.com
        </p>
    </footer>

```
> Plan any PHP code you'll need.

**PHP for general display**

$title: to display the title

$sticky_purchase: to help consumers to not type artwork titles wrongly by sticking the title in
  ```
  $sticky_purchase = $_GET['purchase'];
    if (!empty($sticky_purchase)) {
        $artworkNameBuy = filter_var($sticky_purchase, FILTER_SANITIZE_STRING);
    }
  ```

**PHP for sticky forms**
```
$feedback form feedback
$name $value
$auctionNameError = '';
$artworkNameBuyError = '';
$donationAmountError = '';
$artistNameError = '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $is_application_valid = TRUE;
        $auctionName = trim($_POST['name']);
        $artistName = trim($_POST['artisname']);
        $artworkNameBuy = trim($_POST['artwork-name']);
        $donationAmount = $_POST['donation_amout'];
```

# Complete & Polished Website (Final Submission)

## Gallery Step-by-Step Instructions (Final Submission)
> Write step-by-step instructions for the graders.
> For each set of instructions, assume the grader is starting from index.php.

Viewing all images in your gallery:
1. go to donation page
2. successfully submit an artwork (won't be displayed in shop page because artwork need to be verified, but will show up in the confirmation page of donating an artwork)

View all images for a tag:
1. go to shop page
2. each item in the menu is a tag, clicking it allow user to view all images for a certain tag

View a single image and all the tags for that image:
1. go to shop page
2. click on the + of an image

How to upload a new image:
1. same as "donating a piece of artwork", go to donation.php
2. complete and submit the artwork donation form

How to delete an image:
1. same as "buying a piece of artwork/ donating money"
2.  go to shop.php, click on the money bag emoji at the bottom right of a picture
3. the website will take you to donation.php with artwork title sticky on the "money donation" form
4. complete and submit the money donation form


How to view all tags at once:
1. look at the menu bar on shop page
2. the menu bar displays all existing tags

How to add a tag to an existing image:
1. click the + at the bottom right corner of any image displayed on "shop.php"
2. scroll down, and there is a form for adding tag

How to remove a tag from an existing image:
1. look at the shop page, click the money bag emoji at the right corner of a piece of artwork that is currently in action
2. the website will skip to donation page with the name of the artwork sticky on the money donation for,. Fill in the form and click purchase.


## Reflection (Final Submission)
> Take this time to reflect on what you learned during this assignment. How have you improved since starting this class?

I became more comfortable with php, sql,and html through implementing things in this project. I learned to be more confident in myself and to not afraid of  challenging tasks I don't know exactly what to do at first.
