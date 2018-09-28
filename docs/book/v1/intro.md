# Introduction

This component provides an HTTP Basic Authentication adapter for
[zend-expressive-authentication](https://docs.zendframework.com/zend-expressive-authentication).

HTTP Basic authentication utilizes the user-info section of the URL authority in
order to provide credentials. While the HTTP specifications allow a single value
for the user-info, most implementations require a `:`-separated credential, with
the username first, and the password second; in fact, this is how browsers
always send HTTP Basic credentials, as their prompts are always for the two
values. As such, **this implementation expects both a username and password in
the supplied credentials**.

> ### Only use in trusted networks
>
> Since HTTP Basic transmits the credentials via the URL, it should only be used
> within trusted networks, and never in public-facing sites, as the URL can be
> sniffed by MITM proxies.
