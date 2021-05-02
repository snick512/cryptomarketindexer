# Cryptocurrency Market Indexer (formely Market Data Indexing Engine)

**Cryptocurrency Market Indexer is an old-fashioned crawler which asks services about their data and then stores it. From there, any application can access the SQL data and even update it.**


![alt text](https://urcpu.com/1.png "CMI")

**Meant to be used on private net**

Thanks to MeekroDB and Coin Gecko.

# Features

* Get by-the-minute updates on up to 90 cryptocurrencies straight to your desktop.
* Add/remove coins
* Basic share management (buy/sell)


# Help
* [Installing and Configuring](https://github.com/snick512/cryptomarketindexer/wiki/Installing-and-Configuring)
* [Upgrading](https://github.com/snick512/cryptomarketindexer/wiki/Upgrading-from-0.1.6-to-0.2.7)
* [Portfolio](https://github.com/snick512/cryptomarketindexer/wiki/Portfolio)
* [Adding/Removing coins](https://github.com/snick512/cryptomarketindexer/wiki/Manipuatling-Coinlist-table)
* [Set Simulator](https://github.com/snick512/cryptomarketindexer/wiki/Set-Simulator)
* [Interacting with the API](https://github.com/snick512/cryptomarketindexer/wiki/Interacting-with-the-API)

![alt text](https://urcpu.com/3.png "CMI")

Version 0.2.7.1057

_Checkout Testing branch_

![alt text](https://urcpu.com/4.png "CMI")

# Requirements

**PHP**, **curl** and **MySQL** are required.

## Installing
Before running mdie PHP, curl and MySQL should be installed.

1. Clone/Download all files. 
2. Copy to /var/www/html
3. Download coin logo pack: `wget https://urcpu.com/coin_images.tar.gz`
4. Run prep.php in the web browser.
5. Set a cron to execute every minute. `*/1 * * * * curl "http://127.0.0.1/mdie/crawl.php"`

For detailed install visit the [wiki here](https://github.com/snick512/cryptomarketindexer/wiki/Installing-and-Configuring).

***API queries are limited to 100 per minute***

### Coin Crawling Management

A full coinlist of 4k+ coins can be found at https://urcpu.com/coinlist.pdf or in the www directory. Recommended to check the URL once in awhile to see if it's updated.

When adding coins, you want to use the _slug_. For example, Bitcoin Silver would be **bitcoin-silver**

### Donate

Bitcoin: bc1q579rgt49j577kmmtf3zcxdt476yhs8hezjuqf7

DogeCash: DKpmukeywXMgzvkUsjmGDj9jJExBNxjTb8

Or: [Donate via PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NGF8PZ7V2TAE6&source=url)


### Todo:

* Better code
* Exchange management
* History (kinda already finished)
* Table optimizations


### Known bugs

* Number formats needs addressed to properly display

### License

BSD 3-Clause License

Copyright (c) 2019, Ty Clifford
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its
   contributors may be used to endorse or promote products derived from
   this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
