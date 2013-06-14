mercurial-blog
==============

This is the source code for my personal website, mercuryq.net

The main feature of this website is the encrypted message-passing system.
Messages between users are secured using GPG encryption,
and the passphrases for their GPG keys is never written to disk.
Thus, the server operator cannot read the messages as they are stored on disk,
and has no way to possibly do so as the code is written without intercepting 
communication with the user. Assuming the server operator is trustworthy, the server
is physically secure, and the SSL communication is secure, no attacker or MITM can 
read the contents of any user's messages.
As development continues, I will work on ways to eliminate these potentially 
compromising factors. 

