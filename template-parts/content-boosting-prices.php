<?php
/*
* Content Part of Boosting Templates
*/
 ?>
<script type="text/javascript">

/**
* Unranked: 0
* Bronze: 1
* Silver:2
* Gold:3
* platinum:4
* Diamond:5
* master:6


* Division V: 1
* Division IV: 2
* Division III: 3
* Division II: 4
* Division I: 5
**/

var resolveLeagues = {
    0 : 'unranked',
    1 : 'Bronze',
    2 : 'Silver',
    3 : 'Gold',
    4 : 'Platinum',
    5 : 'Diamond',
    6 : 'Master'
}
var resolveDivisions = {
    1 : 'V',
    2 : 'IV',
    3 : 'III',
    4 : 'II',
    5 : 'I'
}
var resolveType = {
    1 : 'Solo',
    2 : 'Group',
    3 : 'Coaching'
}

//divisions array arrangement "from league-from Division-to League-to Division- Solo = 1 / Group = 2" : Amount USD
// Divisions
var divisionPrices = {
  // b5-b5........b5-b4.........b4-b3.........b3-b2.........b2-b1.........b1-b1........b1-s5...............
    "11111" : 0, "11121" : 13, "12131" : 13, "13141" : 13, "14151" : 13, "15151" : 0, "15211" : 16,
    "21211" : 0, "21221" : 15, "22231" : 16, "23241" : 17, "24251" : 18, "25251" : 0, "25311" : 23,
    "31311" : 0, "31321" : 26, "32331" : 28, "33341" : 32, "34351" : 34, "35351" : 0, "35411" : 37,
    "41411" : 0, "41421" : 45, "42431" : 48, "43441" : 54, "44451" : 56, "45451" : 0, "45511" : 63,
    "51511" : 0, "51521" : 121, "52531" : 149, "53541" : 159, "54551" : 177, "55551" : 0, "55611" : 290,

    "11112" : 0, "11122" : 18, "12132" : 18, "13142" : 18, "14152" : 18, "15152" : 0, "15212" : 20,
    "21212" : 0, "21222" : 24, "22232" : 26, "23242" : 27, "24252" : 28, "25252" : 0, "25312" : 30,
    "31312" : 0, "31322" : 35, "32332" : 39, "33342" : 41, "34352" : 43, "35352" : 0, "35412" : 50,
    "41412" : 0, "41422" : 65, "42432" : 73, "43442" : 80, "44452" : 84, "45452" : 0, "45512" : 88,
    "51512" : 0, "51522" : 0, "52532" : 0, "53542" : 0, "54552" : 0, "55552" : 0, "55612" : 0
}

var pointsPrices = {
    "0-20" : 0, "20-40" : 10, "40-60" : 20, "60-80" : 30, "80-100" : 40
}

//Net Wins array arrangement "from Division-from League- solo = 1 / group = 2] per game = Amount USD
// Net Wins
var netWinPrices = {
    "111" : 2, "121" : 2.5, "131" : 4, "141" : 6, "151" : 12,
    "211" : 2, "221" : 2.5, "231" : 4, "241" : 7, "251" : 16,
    "311" : 2, "321" : 2.5, "331" : 5, "341" : 8.5, "351" : 20,
    "411" : 2, "421" : 3, "431" : 5, "441" : 10, "451" : 25,
    "511" : 2.5, "521" : 3.5, "531" : 5.5, "541" : 11, "551" : 25.5,

    "112" : 3.5, "122" : 5, "132" : 7.5, "142" : 10.5, "152" : 25,
    "212" : 3.5, "222" : 5.5, "232" : 8, "242" : 11, "252" : 32,
    "312" : 4, "322" : 6, "332" : 8, "342" : 12.5, "352" : 45,
    "412" : 4, "422" : 6, "432" : 8.5, "442" : 15.5, "452" : 60,
    "512" : 5, "522" : 7, "532" : 9, "542" : 17.5, "552" : 80
}

//unranked array arrangement "from Leaguee- solo = 1 / group = 2" : Amount USD
// unranked
var unrankedPrices = {
    "01" : 3.5, "11" : 2.7, "21" : 3.5, "31" : 4.5, "41" : 6.3, "51" : 7.2, "61" : 0,
    "02" : 5.4, "12" : 3.5, "22" : 5.5, "32" : 6.3, "42" : 8, "52" : 10.8, "62" : 0
}

//general wins array arrangement "solo = 1/ group = 2" per game = Amount USD
var generalWinPrices = {
    "1" : 3,

    "112" : 2.5, "122" : 2.5, "132" : 3.5, "142" : 6, "152" : 9,
    "212" : 2.5, "222" : 3, "232" : 3.5, "242" : 6, "252" : 11,
    "312" : 2.5, "322" : 3, "332" : 4.5, "342" : 7.5, "352" : 13,
    "412" : 2.5, "422" : 3, "432" : 4.5, "442" : 9, "452" : 15,
    "512" : 2.5, "522" : 3.5, "532" : 5.5, "542" : 9, "552" : 18
}

// coaching prices array arrangement "Hourly = 1 / Games = 2" per game = Amount USD
var coachingPrices = {
    "1" : 3,
    "2" : 4
}
</script>
