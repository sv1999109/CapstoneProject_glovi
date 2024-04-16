import React from 'react';
import { useLocation } from 'react-router-dom';
import { __sveltekit_ywc9kk } from 'sveltekit';

const Navbar = () => {
  const location = useLocation();

 
  __sveltekit_ywc9kk = {
    base: new URL(".", location).pathname.slice(0, -1),
  };

  const element = document.currentScript.parentElement;

  const data = [
    { type: "data", data: { locale: "en" }, uses: {} },
    {
      type: "data",
      data: {
        form: {
          id: "k98w6u",
          valid: false,
          posted: false,
          errors: {},
          data: {
            shipFrom: { label: "", value: "" },
            shipTo: { label: "", value: "" },
            packagingType: "MyPackage",
            packageWeight: 1,
            weightUnit: "Lbs",
          },
          constraints: {
            shipFrom: {
              label: { required: true },
              value: { required: true },
            },
            shipTo: {
              label: { required: true },
              value: { required: true },
            },
            packagingType: { required: true },
            packageWeight: { required: true },
            weightUnit: { required: true },
          },
        },
      },
      uses: {},
    },
  ];

  Promise.all([
    import("_app/immutable/entry/start.g465TzTs.js"),
    import("_app/immutable/entry/app.9g0OJlL-.js"),
  ]).then(([kit, app]) => {
    kit.start(app, element, {
      node_ids: [0, 8],
      data,
      form: null,
      error: null,
    });
  });

  return (

    <>
      <div style={{ display: "contents" }}>
        <header
          class="navbar-default transition-width fixed left-0 right-0 top-0 z-30 border-b border-zinc-200 bg-white shadow-sm duration-300"
        >
          <nav
            class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-5"
            aria-label="Global"
          >
            <div class="flex lg:flex-1">
              <a
                href="index.html"
                title="Multi-Carrier solution specifically designed for Small and Medium size businesses - Compare prices for major carriers and take advantage of our group buying power to save big on your shipments"
                data-sveltekit-reload
                class="-m-1.5 p-1.5"
              ><span class="sr-only" data-svelte-h="svelte-1kiawr4"
              >Secureship</span
                >
                <img
                  src="_app/immutable/assets/app-logo-dark.C1ZesvXS.svg"
                  alt="Secureship Logo"
                  class="h-8 w-auto"
                /></a>
            </div>
            <div class="flex gap-4 lg:hidden">
              <a
                id="link-sign-up"
                class="inline-block rounded-md py-3 text-center font-semibold text-white shadow-sm transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent px-3.5 text-sm bg-accent hover:bg-orange-500 !py-2"
                href="sign-up.html"
                title="Sign up and start Saving on Shipping"
                target="_self"
                data-sveltekit-reload
              >Sign Up</a
              >
              <button
                type="button"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5"
              >
                <span class="sr-only">Open Main Menu</span>
                <svg
                  class="h-[20px] w-[26px]"
                  fill="none"
                  viewBox="0 0 26 20"
                  stroke-width="2"
                  stroke="currentColor"
                  aria-hidden="true"
                >
                  <line y1="1" x2="26" y2="1"></line>
                  <line y1="10" x2="26" y2="10"></line>
                  <line y1="19" x2="26" y2="19"></line>
                </svg>
              </button>
            </div>
            <div class="hidden lg:flex lg:items-center lg:gap-x-6">
              <a
                href="how-it-works.html"
                title="How it Works - Shipping Made Easy"
                class="text-sm font-semibold leading-6 transition hover:text-accent"
                data-sveltekit-reload
              >How it Works</a
              >
              <button
                role="button"
                aria-haspopup="dialog"
                aria-expanded="false"
                data-state="closed"
                id="kHAy6hEEwM"
                data-melt-popover-trigger=""
                data-popover-trigger=""
                type="button"
                class="flex items-center gap-x-1 px-2 py-1 text-sm font-semibold leading-6 transition hover:text-accent focus-visible:rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent"
              >
                Pricing
                <svg
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                  class="h-5 w-5 flex-none transition false"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </button>
              <button
                role="button"
                aria-haspopup="dialog"
                aria-expanded="false"
                data-state="closed"
                id="AYXdjYD55h"
                data-melt-popover-trigger=""
                data-popover-trigger=""
                type="button"
                class="flex items-center gap-x-1 px-2 py-1 text-sm font-semibold leading-6 transition hover:text-accent focus-visible:rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent"
              >
                Integrations
                <svg
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                  class="h-5 w-5 flex-none transition false"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </button>
              <button
                role="button"
                aria-haspopup="dialog"
                aria-expanded="false"
                data-state="closed"
                id="NJwBUWpLp-"
                data-melt-popover-trigger=""
                data-popover-trigger=""
                type="button"
                class="flex items-center gap-x-1 px-2 py-1 text-sm font-semibold leading-6 transition hover:text-accent focus-visible:rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent"
              >
                Support
                <svg
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                  class="h-5 w-5 flex-none transition false"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </button>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-4">
              <a
                id="link-sign-up"
                href="sign-up.html"
                title="Sign up and start Saving on Shipping"
                target="_self"
                class="inline-block rounded-md py-3 text-center font-semibold text-white shadow-sm transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent px-3.5 text-sm bg-accent hover:bg-orange-500 undefined"
                data-sveltekit-reload
              >Sign Up Free</a
              >
              <a
                id="link-login"
                href="sign-in.html"
                title="Login to your Shipper Account"
                target="_self"
                class="inline-block rounded-md border-2 border-primary-dark bg-white px-3.5 py-2.5 text-center text-sm font-semibold text-primary shadow-sm hover:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent undefined"
              >Login</a
              >
            </div>
          </nav>
        </header>
        <main>
          <div id="page-hero" class="z-10">
            <div class="background-transition relative pt-24 bg-hero-1">
              <div
                id="jump-to-estimate"
                class="sticky top-[92dvh] z-30 h-0 transition-all lg:hidden"
              >
                <button
                  class="mx-auto flex w-40 items-center justify-center gap-2 rounded-full bg-white/90 px-5 py-3 text-center text-sm font-semibold text-primary-dark shadow-[0px_5px_24px_rgba(0,_0,_0,_0.25)] backdrop-blur transition hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent"
                >
                  Get Estimate
                </button>
              </div>
              <div
                class="mx-auto grid max-w-6xl grid-cols-1 place-items-center gap-8 px-4 pb-16 pt-7 sm:px-8 md:pb-6 lg:grid-cols-[1fr_1.5fr] lg:place-items-start lg:gap-0 undefined"
              >
                <section aria-labelledby="section-title" class="sm:row-start-1">
                  <h1
                    id="section-title"
                    class="text-3.5xl font-bold md:text-4xl lg:text-4.5xl undefined"
                  >

                  </h1>
                  <h2 id="section-sub-title" class="mt-5 max-w-xl text-lg">

                  </h2>
                </section>
                <div class="lg:row-span-2">
                  <div
                    class="flex min-h-[16.875rem] items-center justify-center sm:min-h-[29.9rem] md:min-h-[30.25rem]"
                  >
                    <figure
                      class="relative lg:h-[29.06em] max-w-[33.75em] lg:w-[35em] lg:max-w-[35em] xl:w-[36.75em] xl:max-w-[36.75em]"
                      aria-labelledby="banner-caption"
                    >
                      <picture
                      ><source
                          type="image/avif"
                          srcset="
                          /_app/immutable/assets/header-1.B5A_YVuJ.avif 480w
                        " />
                        <source
                          type="image/webp"
                          srcset="
                          /_app/immutable/assets/header-1.fQ4Zbchy.webp 480w
                        " />
                        <img
                          loading="lazy"
                          decoding="async"
                          width="480"
                          height="384"
                          alt="need alt text"
                          class="h-full w-full object-contain"
                          src="_app/immutable/assets/header-1.CrBN_Ngj.jpg"

                        /></picture>
                      <div
                        id="pricing-banner"
                        class="absolute left-0 top-0 h-full w-full"
                        role="presentation"
                      ></div>
                      <figcaption id="banner-caption" class="sr-only">
                        need caption like what on the picture or what it is doing
                      </figcaption>
                    </figure>
                  </div>
                </div>
                <div class="invisible sm:row-start-3 md:visible lg:row-start-2">
                  <div
                    class="mx-auto grid grid-cols-4 gap-5 sm:max-w-full sm:grid-cols-8 md:mx-0 lg:grid-cols-4 text-hero-1-accent"
                    role="group"
                    aria-label="A grid of different shipping carriers"
                  >
                    <div class="h-14 w-14">
                      <svg
                        viewBox="0 0 59 59"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="fedexLogo-luj7sqyt-1rpzax"
                        role="img"
                      >
                        <title id="fedexLogo-luj7sqyt-1rpzax">FedEx Logo</title>
                        <path
                          d="M39.2999 26.2V29H35.2V31.5H39.2999V34.4L42.9 30.3L39.2999 26.2Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M53.4001 32.4H53.1001V32.9H53.4001C53.7001 32.9 53.7001 32.8 53.7001 32.6C53.8001 32.5 53.7001 32.4 53.4001 32.4Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M17.3 27.7C16.5 27.7 15.9 28.2 15.7 29H19C18.8 28.2 18.2 27.7 17.3 27.7Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M26.4001 28C25.2001 28 24.6001 29.1 24.6001 30.3C24.6001 31.4 25.3001 32.4 26.4001 32.4C27.6001 32.4 28.1001 31.4 28.1001 30.3C28.1001 29.1 27.6001 28 26.4001 28Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M53.4 31.8C52.7 31.8 52.2 32.3 52.2 33.1C52.2 33.8 52.7 34.4 53.4 34.4C54.1 34.4 54.5999 33.9 54.5999 33.1C54.6999 32.4 54.2 31.8 53.4 31.8ZM53.7999 34C53.6999 33.8 53.7 33.6 53.7 33.4C53.7 33.2 53.6 33.2 53.4 33.2H53.0999V34H52.7999V32.2H53.5C53.9 32.2 54.0999 32.4 54.0999 32.7C54.0999 32.9 53.9999 33.1 53.7999 33.1C53.9999 33.1 54 33.3 54 33.5C54 33.7 54.0999 34 54.0999 34H53.7999Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M51.9 0H6.5C2.9 0 0 2.9 0 6.5V51.9C0 55.5 2.9 58.4 6.5 58.4H51.9C55.5 58.4 58.4 55.5 58.4 51.9V6.5C58.4 2.9 55.5 0 51.9 0ZM31.2 34.4H28.2V33.6C27.7 34.4 26.8 34.9 25.8 34.9C23.5 34.9 21.9 33.1 21.6 30.9H15.7C15.7 31.8 16.5 32.6 17.4 32.6C18.2 32.6 18.5 32.4 18.9 31.9H21.8C21 33.8 19.6 34.8 17.4 34.8C14.8 34.8 12.7 32.9 12.7 30.2C12.7 29.8 12.8 29.3 12.9 28.9H9.4V34.3H6V21.5H13.6V24.4H9.4V26.2H13.2V27.9C14 26.5 15.4 25.7 17.3 25.7C19.6 25.7 21.1 26.9 21.7 28.9C22.2 27.1 23.7 25.8 25.7 25.8C26.7 25.8 27.5 26.1 28.2 26.8V21.5H31.2V34.4ZM46.5 34.4L44.7 32.4L42.9 34.4H39.2H32.1V21.5H39.2V24.4H35.1V26.2H39.2H43L44.8 28.2L46.5 26.2H50.2L46.6 30.3L50.3 34.4H46.5ZM53.4 34.6C52.6 34.6 51.9 34 51.9 33.1C51.9 32.2 52.6 31.6 53.4 31.6C54.2 31.6 54.9 32.2 54.9 33.1C55 34 54.2 34.6 53.4 34.6Z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </div>
                    <div class="h-14 w-14">
                      <svg
                        viewBox="0 0 59 59"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="upsLogo-luj7sqyt-6rjrpb"
                        role="img"
                      >
                        <title id="upsLogo-luj7sqyt-6rjrpb">UPS Logo</title>
                        <path
                          d="M52.4 0H7C3.4 0 0.5 2.9 0.5 6.5V51.9C0.5 55.5 3.4 58.4 7 58.4H52.4C56 58.4 58.9 55.5 58.9 51.9V6.5C58.9 2.9 56 0 52.4 0ZM44.7 32.5C44.7 36.1 43.4 39.2 40.7 41.5C38.1 43.6 29.7 47.3 29.7 47.3C29.7 47.3 21.3 43.6 18.7 41.6C16 39.3 14.7 36.2 14.7 32.6V14.8C21.3 11.2 29.7 11.5 29.7 11.5C29.7 11.5 38.1 11.2 44.7 14.8V32.5Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M16 32.6C16 35.9 17.2 38.7 19.6 40.6C21.7 42.4 28 45.2 29.8 45.9C31.6 45.1 37.9 42.2 40 40.6C42.4 38.7 43.6 35.9 43.6 32.6V15.1C34.8 14.3 24.3 14.7 16 22.3V32.6ZM39.1 22.9C40.5 22.8 41.5 23.4 42 23.7V26C41.5 25.5 40.6 24.9 39.6 24.9C38.9 24.9 38.1 25.3 38.1 26.2C38.1 27.1 38.9 27.5 39.9 28.1C42.1 29.4 42.6 30.6 42.5 32.1C42.5 33.8 41.3 35.6 38.7 35.6C37.6 35.6 36.6 35.2 35.8 34.8V32.4C36.5 33 37.5 33.5 38.3 33.5C39.3 33.5 39.9 33 39.9 32.1C39.8 31.3 39.4 30.8 38.2 30.1C36.1 28.9 35.6 27.8 35.5 26.4C35.5 24.2 37.3 23 39.1 22.9ZM26.6 23.9C27.6 23.3 28.7 23 30.2 23C33.3 23 35.1 25.4 35.1 29.2C35.1 33 33.4 35.7 30.5 35.7C29.9 35.7 29.5 35.6 29.3 35.5V41.1H26.7V23.9H26.6ZM17.2 23.1H19.9V31.5C19.9 32.2 20.1 33.3 21.3 33.3C21.8 33.3 22.2 33.2 22.5 33V23H25.2V34.5C24.2 35.2 22.8 35.6 21.2 35.6C18.6 35.6 17.2 34.2 17.2 31.3V23.1Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M32.1996 29.1C32.1996 26.1 31.5996 24.9 30.0996 24.9C29.7996 24.9 29.3996 25.1 29.1996 25.1H29.0996V33.2C29.2996 33.3 29.5996 33.4 29.8996 33.4C31.4996 33.4 32.1996 32 32.1996 29.1Z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </div>
                    <div class="h-14 w-14">
                      <svg
                        viewBox="0 0 59 59"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="candapostLogo-luj7sqyt-axugl1"
                        role="img"
                      >
                        <title id="canparLogo-luj7sqyt-axugl1">Canpar Logo</title>
                        <path
                          d="M16.4004 30.6C16.4004 31 16.8004 31.1 17.3004 31.1C18.2004 31.1 18.6004 30.6 18.8004 29.7C18.3004 29.8 17.8004 29.9 17.3004 29.9C16.8004 30 16.4004 30.2 16.4004 30.6Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M35.3004 28C34.1004 28 33.9004 29.4 33.9004 29.9V30C33.9004 30.5 34.4004 30.9 34.9004 30.8C36.0004 30.8 36.4004 29.7 36.3004 29C36.3004 28.4 36.2004 28 35.3004 28Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M41.9004 30.6C41.9004 31 42.3004 31.1 42.8004 31.1C43.7004 31.1 44.1004 30.6 44.3004 29.7C43.8004 29.8 43.3004 29.9 42.8004 29.9C42.3004 30 41.9004 30.2 41.9004 30.6Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M51.9996 0H6.59961C2.99961 0 0.0996094 2.9 0.0996094 6.5V51.9C0.0996094 55.5 2.99961 58.4 6.59961 58.4H51.9996C55.5996 58.4 58.4996 55.5 58.4996 51.9V6.5C58.4996 2.9 55.5996 0 51.9996 0ZM8.4996 32.4C5.5996 32.4 4.1996 30.9 4.1996 28.8C4.1996 26.2 6.19961 24.1 9.59961 24.1C11.7996 24.1 13.7996 24.9 13.7996 27.2H10.8996C10.8996 26.5 10.4996 26 9.4996 26C7.7996 26 7.1996 27.6 7.1996 28.7C7.1996 29.3 7.39961 30.4 8.79961 30.4C9.79961 30.4 10.2996 29.9 10.4996 29.2H13.4996C13.3996 30.1 12.5996 32.4 8.4996 32.4ZM20.9996 32.2H18.2996C18.1996 32 18.1996 31.9 18.1996 31.7C17.6996 32.2 16.7996 32.4 15.9996 32.4C14.7996 32.4 13.6996 32 13.6996 30.9C13.6996 29.4 15.0996 29 17.1996 28.8C17.9996 28.8 19.1996 28.8 19.1996 28.1C19.1996 27.7 18.7996 27.6 18.2996 27.6C17.7996 27.6 17.3996 27.8 17.1996 28.2H14.5996C14.9996 26.7 16.4996 26.3 18.2996 26.3C19.5996 26.3 21.7996 26.4 21.7996 27.8C21.7996 28.7 20.8996 31.3 20.8996 31.7C20.9996 32.2 20.8996 32 20.9996 32.2ZM26.5996 32.3L27.2996 29.6C27.3996 29.3 27.4996 29 27.4996 28.6C27.4996 28.2 27.1996 28.1 26.6996 28.1C25.7996 28.1 25.4996 28.6 25.3996 29.2L24.5996 32.3H21.7996L23.2996 26.5H25.9996L25.7996 27.2C26.3996 26.6 27.1996 26.3 27.9996 26.3C29.2996 26.3 30.3996 26.7 30.3996 27.9C30.3996 28.3 30.2996 28.6 30.1996 29L29.2996 32.2H26.5996V32.3ZM35.5996 32.4C34.7996 32.4 33.9996 32.3 33.3996 31.6L32.7996 34.2H29.9996L31.9996 26.5H34.6996L34.4996 27.1C34.9996 26.6 35.6996 26.3 36.3996 26.3C38.3996 26.3 38.9996 27.7 38.9996 28.7C39.0996 30.4 37.9996 32.4 35.5996 32.4ZM46.4996 32.2H43.7996C43.6996 32 43.6996 31.9 43.6996 31.7C43.1996 32.2 42.2996 32.4 41.4996 32.4C40.2996 32.4 39.1996 32 39.1996 30.9C39.1996 29.4 40.5996 29 42.6996 28.8C43.4996 28.8 44.6996 28.8 44.6996 28.1C44.6996 27.7 44.2996 27.6 43.7996 27.6C43.2996 27.6 42.8996 27.8 42.6996 28.2H40.0996C40.4996 26.7 41.9996 26.3 43.7996 26.3C45.0996 26.3 47.2996 26.4 47.2996 27.8C47.2996 28.7 46.3996 31.3 46.3996 31.7C46.4996 32.2 46.3996 32 46.4996 32.2ZM53.8996 28.4C53.5996 28.3 53.1996 28.3 52.7996 28.3C51.5996 28.3 50.9996 28.7 50.6996 29.9L50.0996 32.3H47.2996L48.7996 26.6H51.4996L51.2996 27.5C51.7996 26.9 52.5996 26.5 53.3996 26.5C53.6996 26.5 53.9996 26.5 54.3996 26.6L53.8996 28.4ZM54.7996 25.2C46.9996 23.6 39.0996 22.9 31.0996 23.4C23.6996 23.8 17.3996 25.3 15.5996 25.9C17.2996 25.3 22.3996 23.5 29.9996 22.6C36.3996 21.9 45.6996 21.7 55.1996 23.6L54.7996 25.2Z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </div>
                    <div class="h-14 w-14">
                      <svg
                        viewBox="0 0 59 59"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="uspsLogo-luj7sqyt-hsb6yo"
                        role="img"
                      >
                        <title id="uspsLogo-luj7sqyt-hsb6yo">USPS Logo</title>
                        <path
                          d="M52.4996 0H7.09961C3.49961 0 0.599609 2.9 0.599609 6.5V51.9C0.599609 55.5 3.49961 58.4 7.09961 58.4H52.4996C56.0996 58.4 58.9996 55.5 58.9996 51.9V6.5C58.9996 2.9 56.0996 0 52.4996 0ZM50.5996 25.2L50.1996 26.3L49.7996 27.4L49.3996 28.3L48.9996 28.9L48.8996 29.1L48.7996 29.2L48.3996 29.3L47.8996 29.5L47.1996 29.8L46.3996 30.1L45.3996 30.5L44.2996 30.9L42.9996 31.3L41.5996 31.9L40.0996 32.4L38.5996 33L35.2996 34.3L33.5996 35L31.8996 35.6L30.1996 36.3L28.3996 37L26.6996 37.6L25.0996 38.3L23.3996 38.9L21.7996 39.5L18.7996 40.7L17.4996 41.2L15.9996 42L14.8996 42.4L13.8996 42.8L13.0996 43.2L12.3996 43.4L11.8996 43.6H8.79961L8.8996 43.2L9.29959 43.1L10.2996 42.6L11.3996 42.1L12.6996 41.4L14.1996 40.7L15.5996 40L17.0996 39.3L18.4996 38.6L19.8996 37.9L21.1996 37.2L22.2996 36.6L23.2996 36.2L23.9996 35.8L24.4996 35.6L25.1996 35.2L25.8996 34.8L26.6996 34.4L27.4996 34L28.1996 33.6L29.0996 33.2L29.8996 32.8L30.7996 32.4L31.6996 32L36.1996 30.1L38.1996 29.4L38.4996 29.3L38.7996 29.2L39.1996 29.1L40.4996 28.7L42.0996 28.3L42.5996 28.2L44.1996 27.8L45.0996 27.7L45.3996 27.6L45.5996 27.5H45.7996L45.9996 27.4L46.0996 27.3H46.1996V27.2L46.0996 26.9L45.8996 26.8L45.5996 26.7H45.2996L44.8996 26.6H44.4996L43.9996 26.7L43.0996 26.8L42.0996 26.9L41.0996 27.1L39.9996 27.3L38.8996 27.6L37.6996 28L36.5996 28.4L35.3996 28.8L34.2996 29.2L33.1996 29.6L32.1996 30L31.1996 30.4L30.2996 30.8L29.5996 31.1L28.8996 31.4L28.3996 31.7L25.5996 22.9H43.5996L43.6996 22.5L43.3996 22.1L42.9996 21.9L42.2996 21.7L41.5996 21.5L39.6996 21.2L36.5996 21H14.1996L15.6996 14.5L16.7996 14.8L18.3996 15.1L19.2996 15.3L20.2996 15.5L21.2996 15.6L22.2996 15.9L23.3996 16L24.4996 16.3L28.0996 17L29.1996 17.3L30.3996 17.5L31.3996 17.7L32.4996 17.9L33.4996 18.1L34.4996 18.2L35.3996 18.4L36.2996 18.5L36.9996 18.7L37.6996 18.9L38.2996 19L38.7996 19.1L39.1996 19.2L39.3996 19.3H39.4996L40.4996 19.5L41.3996 19.6L42.0996 19.8L42.6996 19.9L43.2996 20.1L43.6996 20.2L44.2996 20.5L44.4996 20.6L44.8996 21V21.1L44.9996 21.2V21.3H48.1996L48.4996 21.4H48.7996L48.9996 21.5H49.1996L49.3996 21.6L49.9996 21.9L50.0996 22.1L50.5996 22.9L50.6996 23.9L50.5996 25.2Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M48.8 23.6L48.5 23.4L48.1 23.2L47.7 23.1H47.1H44H43.9L43.7 23.2L43.6 23.5L43.4 23.6L43.3 23.7L43 23.9L42.8 24L41.3 24.3H41H40.7H40.4L39.9 24.4L39.7 24.5L39.5 24.6V24.7V24.8L39.6 25H39.9L40.2 25.1H41L41.4 25H41.8L42.9 24.8H43.4H44L44.5 24.7L45 24.6H45.5H47.5H47.7L47.9 24.7L48 24.9V25.2V25.5L47.9 25.9L47.7 26.3L47.5 26.9L47.4 27.4L47.3 27.7L47.4 27.8H47.6L47.9 27.5L48 27.2L48.3 26.9L48.5 26.4L48.7 25.9L48.9 25.4L49.1 25V24.6V24.2L49 23.8L48.8 23.6Z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </div>
                    <div class="h-14 w-14">
                      <svg
                        viewBox="0 0 59 59"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="purolatorLogo-luj7sqyt-kizgbl"
                        role="img"
                      >
                        <title id="purolatorLogo-luj7sqyt-kizgbl">
                          Purolator Logo
                        </title>
                        <path
                          d="M51.9 0.0999756H6.5C2.9 0.0999756 0 2.99998 0 6.59998V52C0 55.6 2.9 58.5 6.5 58.5H51.9C55.5 58.5 58.4 55.6 58.4 52V6.59998C58.4 2.99998 55.5 0.0999756 51.9 0.0999756ZM10.6 32.3C10.4 32.1 10.3 31.8 10.3 31.5C10.3 30.9 10.8 30.4 11.4 30.4H22.1L17.9 39.5L10.6 32.3ZM19.9 41.6L30.2 19.5C31 17.9 32.3 17 34 17H35.7L24.3 41.6H19.9ZM37.8 39.1C37 40.7 35.7 41.6 34 41.6H27.3L38.7 17H48.1C48.1 17 38.6 37.5 37.8 39.1Z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </div>
                    <div class="h-14 w-14">
                      <svg
                        viewBox="0 0 59 59"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="glsLogo-luj7sqyt-cmu8sm"
                        role="img"
                      >
                        <title id="glsLogo-luj7sqyt-cmu8sm">GLS Logo</title>
                        <path
                          d="M52.4 0.0999756H7C3.4 0.0999756 0.5 2.99998 0.5 6.59998V52C0.5 55.6 3.4 58.5 7 58.5H52.4C56 58.5 58.9 55.6 58.9 52V6.59998C58.9 2.99998 56 0.0999756 52.4 0.0999756ZM45.8 38.9H40.2L41.6 31.6C40.7 33.1 38.3 35.9 32.6 37.9C24.1 40.3 14.5 38.2 11.4 33.2C8.7 28.8 13.3 22.2 21.5 19.7C13.2 23.2 10.8 28.8 13.6 32.1C16.9 35.9 29.2 37.5 35.4 28.3H27.9L29 23H48.9L45.8 38.9Z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </div>
                    <div class="h-14 w-14">
                      <svg
                        viewBox="0 0 59 59"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-labelledby="candapostLogo-luj7sqyt-84tdt1"
                        role="img"
                      >
                        <title id="candapostLogo-luj7sqyt-84tdt1">
                          Candapost Logo
                        </title>
                        <path
                          d="M29.4 10.7C19.1 10.7 10.8 19 10.8 29.2C10.8 39.4 19.2 47.7 29.4 47.7C39.7 47.7 48 39.4 48 29.2C48 19 39.7 10.7 29.4 10.7ZM35.7 37.6H17.5L19.3 35.8L34.6001 35L35.2 34.4H20.7L22 33.1L37.3 32.5L37.9 31.7H23.4L24.7 30.4L40 29.6L40.6001 29H25.6001L17.5 19.6L44.7 28.7L35.7 37.6Z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M52.2 0H6.69995C3.09995 0 0.199951 2.8 0.199951 6.5V52C0.199951 55.6 2.99995 58.5 6.69995 58.5H52.2C55.7999 58.5 58.7 55.5 58.7 52V6.4C58.6 2.8 55.7999 0 52.2 0ZM29.3999 48.7C18.5999 48.7 9.79996 40 9.79996 29.2C9.79996 18.5 18.5999 9.7 29.3999 9.7C40.1999 9.7 49 18.4 49 29.2C49 39.9 40.1999 48.7 29.3999 48.7Z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </div>
                    <div
                      class="flex flex-col items-center justify-center rounded-md h-14 w-14 border-2 border-hero-1-accent"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-4 w-4"
                        aria-hidden="true"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                      <span
                        class="text-center font-semibold leading-[1] sm:text-[0.25em] mt-0.5 text-[0.25em]"
                      >and <br aria-hidden="true" />
                        more</span
                      >
                    </div>
                  </div>
                </div>
                <div
                  id="hero-get-estimate"
                  class="z-10 mt-2 max-lg:transition-opacity lg:col-span-2 lg:row-start-3 max-lg:opacity-0"
                >
                  <div id="estimate-wrapper">
                    <section
                      id="get-estimation"
                      aria-labelledby="section-get-estimate-title"
                      class="rounded-3xl bg-white px-4 py-6 shadow-[0px_8px_40px_rgba(0,_0,_0,_0.1)] sm:px-6 lg:px-8 lg:py-8"
                    >
                      <div class="flex items-center justify-between">
                        <h2
                          id="section-get-estimate-title"
                          class="text-2xl font-semibold md:text-3xl"
                        >
                          Get Estimate
                        </h2>
                        <button
                          class="mr-2 text-xs !font-normal !text-gray-500 underline underline-offset-2 lg:hidden inline-block rounded-md py-2.5 text-center text-sm font-semibold text-primary underline transition hover:text-accent focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent false"
                          type="button"
                          aria-busy="false"
                        >
                          Advanced
                        </button>
                      </div>
                      <form
                        id="form-get-estimate"
                        action="https://secureship.ca/estimate?/getEstimate"
                        method="POST"
                        class="mb-2 mt-3 lg:flex"
                      >
                        <div
                          class="grid grid-cols-[1fr_1fr_1.1em_1fr_1fr] gap-x-2.5 gap-y-4 sm:gap-x-6 md:grid-cols-[1fr_1.1em_1fr_1.3fr_4.5em_4em] md:gap-x-5 lg:flex-1"
                        >
                          <div class="col-span-2 md:col-span-1">
                            <div class="flex items-center gap-3">
                              <div class="relative h-20 flex-1">
                                <input
                                  class="h-10 text-sm leading-[2.5rem] peer block w-full text-ellipsis border-0 text-primary placeholder-transparent outline-none focus:ring-0 border-b-2 border-gray-300 px-0 py-0 pr-7 focus:border-accent"
                                  id="ship-from"
                                  placeholder="Ship from"
                                  name="shipFrom"
                                  autocomplete="off"
                                  required
                                  value=""
                                  type="text"
                                />
                                <label
                                  for="ship-from"
                                  class="sm:peer-placeholder-shown:text-sm absolute text-xs transition-all -top-3.5 left-0 leading-6 text-gray-600 peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-500 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-gray-600"
                                >Ship from</label
                                >
                                <div
                                  class="absolute right-0 top-2 flex items-center gap-1.5"
                                >
                                  <button
                                    type="button"
                                    class="inline-block rounded-full p-1 hover:text-accent focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent text-gray-400"
                                    style={{ transform: "rotate(0)", transition: "0.3s cubic-bezier(0.25, 0.8, 0.5, 1)", visibility: "0s" }}
                                    tabindex="-1"
                                    data-testid="button-icon"
                                  >
                                    <span class="sr-only"></span>
                                    <svg
                                      viewBox="0 0 20 20"
                                      fill="currentColor"
                                      aria-hidden="true"
                                      class="h-4 w-4"
                                    >
                                      <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd"
                                      ></path>
                                    </svg>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            class="mt-3 h-6 w-6"
                            aria-hidden="true"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                              clip-rule="evenodd"
                            ></path>
                          </svg>
                          <div class="col-span-2 md:col-span-1">
                            <div class="flex items-center gap-3">
                              <div class="relative h-20 flex-1">
                                <input
                                  class="h-10 text-sm leading-[2.5rem] peer block w-full text-ellipsis border-0 text-primary placeholder-transparent outline-none focus:ring-0 border-b-2 border-gray-300 px-0 py-0 pr-7 focus:border-accent"
                                  id="ship-to"
                                  placeholder="Ship to"
                                  name="shipTo"
                                  autocomplete="off"
                                  required
                                  value=""
                                  type="text"
                                />
                                <label
                                  for="ship-to"
                                  class="sm:peer-placeholder-shown:text-sm absolute text-xs transition-all -top-3.5 left-0 leading-6 text-gray-600 peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-500 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-gray-600"
                                >Ship to</label
                                >
                                <div
                                  class="absolute right-0 top-2 flex items-center gap-1.5"
                                >
                                  <button
                                    type="button"
                                    class="inline-block rounded-full p-1 hover:text-accent focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent text-gray-400"
                                    style={{
                                      transform: 'rotate(0)',
                                      transition: '0.3s cubic-bezier(0.25, 0.8, 0.5, 1), visibility 0s',
                                    }}
                                    tabindex="-1"
                                    data-testid="button-icon"
                                  >
                                    <span class="sr-only"></span>
                                    <svg
                                      viewBox="0 0 20 20"
                                      fill="currentColor"
                                      aria-hidden="true"
                                      class="h-4 w-4"
                                    >
                                      <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd"
                                      ></path>
                                    </svg>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-span-2 md:col-span-1 md:ml-4">
                            <div class="">
                              <input
                                type="hidden"
                                value="MyPackage"
                                id="packaging-type"
                                name="packagingType"
                              />
                              <div class="relative">
                                <label
                                  id="headlessui-listbox-label-1929"
                                  class="absolute left-0 transition-all -top-3 text-xs text-gray-600"
                                >Package Type</label
                                >
                                <div class="h-20">
                                  <div class="flex gap-4">
                                    <button
                                      id="headlessui-listbox-button-1930"
                                      type="button"
                                      aria-haspopup
                                      aria-expanded="false"
                                      class="h-10 text-sm relative w-full cursor-default text-left focus:outline-none border-b-2 border-gray-300 py-2 pr-10 focus-visible:border-accent active:border-accent"
                                    >
                                      <span
                                        class="absolute bottom-2 block truncate transition group-focus-within:bottom-6 text-primary"
                                      >My Package</span
                                      >
                                      <span
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                      ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        class="h-5 w-5 text-primary-light"
                                        aria-hidden="true"
                                      >
                                          <path
                                            fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                            clip-rule="evenodd"
                                          ></path></svg
                                        ></span>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="md:hidden"></div>
                          <div class="">
                            <div class="flex items-center gap-3">
                              <div class="relative h-20 flex-1">
                                <input
                                  class="h-10 text-sm leading-[2.5rem] peer block w-full border-0 border-b-2 border-gray-300 px-0 py-0 text-primary placeholder-transparent outline-none focus:border-accent focus:ring-0"
                                  id="package-weight"
                                  min="0"
                                  step="0.1"
                                  name="packageWeight"
                                  placeholder="Weight"
                                  type="number"
                                  value="1"
                                />
                                <label
                                  for="package-weight"
                                  class="sm:peer-placeholder-shown:text-sm absolute max-w-[14.56rem] truncate md:max-w-full -top-3.5 left-0 text-xs leading-6 text-gray-600 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-500 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-gray-600"
                                >Weight
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="">
                            <div class="">
                              <input
                                type="hidden"
                                value="Lbs"
                                id="weight-units"
                                name="weightUnit"
                              />
                              <div class="relative">
                                <label
                                  id="headlessui-listbox-label-1931"
                                  class="absolute left-0 transition-all -top-3 text-xs text-gray-600"
                                >Units</label
                                >
                                <div class="h-20">
                                  <div class="flex gap-4">
                                    <button
                                      id="headlessui-listbox-button-1932"
                                      type="button"
                                      aria-haspopup
                                      aria-expanded="false"
                                      class="h-10 text-sm relative w-full cursor-default text-left focus:outline-none border-b-2 border-gray-300 py-2 pr-10 focus-visible:border-accent active:border-accent"
                                    >
                                      <span
                                        class="absolute bottom-2 block truncate transition group-focus-within:bottom-6 text-primary"
                                      >Lbs</span
                                      >
                                      <span
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                                      ><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        class="h-5 w-5 text-primary-light"
                                        aria-hidden="true"
                                      >
                                          <path
                                            fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                            clip-rule="evenodd"
                                          ></path></svg
                                        ></span>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="mt-7 text-center lg:ml-5 lg:mt-0 lg:shrink-0 lg:grow-0"
                        >
                          <button
                            id="button-advanced-estimate"
                            class="mr-2 hidden text-xs !font-normal !text-gray-500 lg:inline-block inline-block rounded-md py-2.5 text-center text-sm font-semibold text-primary underline transition hover:text-accent focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent false"
                            type="button"
                            aria-busy="false"
                          >
                            Advanced
                          </button>
                          <button
                            id="button-get-estimate"
                            class="inline-block rounded-md py-2.5 text-center font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent px-3.5 text-sm bg-accent hover:bg-orange-500 false rounded-xl px-5 py-3.5"
                            type="button"
                            title="Shipping Estimate provider will find all the best prices through all the carriers supported on Secureship including CanadaPost, Purolator, UPS, FedEx, GLS and more"
                            aria-busy="false"
                          >
                            Get Estimate
                          </button>
                        </div>
                      </form>
                    </section>
                  </div>
                </div>
              </div>
            </div>
            <section
              class="relative overflow-hidden px-4 pb-8 md:pb-28 lg:pb-16 xl:pb-0 undefined"
              aria-labelledby="section-secureship-stats-title"
            >
              <div
                class="background-transition absolute left-0 right-0 top-0 h-1/2 bg-hero-1"
              ></div>
              <div
                class="absolute bottom-10 left-0 right-0 sm:bottom-0 text-hero-1"
              >
                <svg
                  viewBox="0 0 390 926"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                  class="sm:hidden"
                  aria-hidden="true"
                >
                  <path
                    d="M278.952 894.869C132.074 942.082 11.8175 941.65 -35 851.126L-17.5582 0H659V902.171C585.561 819.119 425.831 847.657 278.952 894.869Z"
                    fill="url(#fci60sj1)"
                  ></path>
                  <defs>
                    <linearGradient
                      id="fci60sj1"
                      x1="312"
                      y1="577.268"
                      x2="312"
                      y2="928.182"
                      gradientUnits="userSpaceOnUse"
                    >
                      <stop stop-color="currentColor"></stop>
                      <stop offset="1" stop-color="currentColor"></stop>
                    </linearGradient>
                  </defs>
                </svg>
                <svg
                  viewBox="0 0 768 870"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                  class="hidden sm:block"
                  aria-hidden="true"
                >
                  <path
                    d="M307.071 831.654C127.389 889.81 -19.7262 889.278 -77 777.771L-55.6627 0H772V840.647C682.159 738.346 486.754 773.498 307.071 831.654Z"
                    fill="url(#6dq5hqi1)"
                  ></path>
                  <defs>
                    <linearGradient
                      id="6dq5hqi1"
                      x1="347.5"
                      y1="440.434"
                      x2="347.5"
                      y2="872.687"
                      gradientUnits="userSpaceOnUse"
                    >
                      <stop stop-color="currentColor"></stop>
                      <stop offset="1" stop-color="currentColor"></stop>
                    </linearGradient>
                  </defs>
                </svg>
              </div>
              <div
                class="mx-auto flex max-w-7xl flex-col sm:flex-row-reverse md:-translate-x-[18%] md:items-center lg:-translate-x-[25%]"
              >
                <div
                  class="relative md:mt-0 md:translate-x-[10%] lg:translate-x-[25%]"
                >
                  <h2
                    id="section-secureship-stats-title"
                    class="text-2xl font-bold leading-tight lg:text-3xl undefined"
                  >

                  </h2>
                  <h3 id="section-secureship-stats-sub-title" class="mt-3">

                  </h3>
                  <ul class="mt-8 grid grid-cols-2 gap-x-8 gap-y-10">
                    <li class="border-l-4 border-white pl-4">
                      <div class="text-3.5xl font-semibold lg:text-4.5xl">
                        180+
                      </div>
                      <div>Shipped to Countries</div>
                    </li>
                    <li class="border-l-4 border-white pl-4">
                      <div class="text-3.5xl font-semibold lg:text-4.5xl">
                        Millions
                      </div>
                      <div>Shipments Completed</div>
                    </li>
                    <li class="border-l-4 border-white pl-4">
                      <div class="text-3.5xl font-semibold lg:text-4.5xl">
                        36K
                      </div>
                      <div>Happy Customers</div>
                    </li>
                    <li class="border-l-4 border-white pl-4">
                      <div class="text-3.5xl font-semibold lg:text-4.5xl">
                        30+
                      </div>
                      <div>Integrations &amp; Carriers</div>
                    </li>
                  </ul>
                </div>
                <div
                  class="relative -ml-44 mr-5 mt-5 translate-y-4 sm:w-[43.75em] md:ml-0 lg:w-[76em] lg:translate-y-6"
                >
                  <picture
                  ><source
                      type="image/avif"
                      srcset="
                      /_app/immutable/assets/globe.BwncZz6-.avif  480w,
                      /_app/immutable/assets/globe.B57OcEiu.avif 1024w,
                      /_app/immutable/assets/globe.BJ2GH5tG.avif 1920w
                    " />
                    <source
                      type="image/webp"
                      srcset="
                      /_app/immutable/assets/globe.p8mnWDOq.webp  480w,
                      /_app/immutable/assets/globe.cfEX80xi.webp 1024w,
                      /_app/immutable/assets/globe.BDopPRfh.webp 1920w
                    " />
                    <source
                      type="image/jpeg"
                      srcset="
                      /_app/immutable/assets/globe.BiI25dPM.jpg  480w,
                      /_app/immutable/assets/globe.CmYiAXk1.jpg 1024w,
                      /_app/immutable/assets/globe.BxGpWqk1.jpg 1920w
                    " />
                    <img
                      loading="lazy"
                      decoding="async"
                      width="1920"
                      height="1920"
                      alt="Earth surrounded with various carriers"
                      class="p-[5%] sm:p-[1.15em] lg:p-[2em]"
                      src="_app/immutable/assets/globe.BxGpWqk1.jpg"

                    /></picture>
                  <div
                    id="global-lottie"
                    class="absolute inset-0 -m-[5%] sm:-m-[1.4375em] lg:-m-[2.5em]"
                    role="presentation"
                  ></div>
                </div>
              </div>
            </section>
          </div>
          <section
            class="relative overflow-hidden px-4 pb-8 pt-4 mt-6 svelte-2y4ya6"
            aria-labelledby="section-designed-for-shippers-title"
          >
            <div
              class="absolute -bottom-20 left-0 right-0 sm:-bottom-36 md:bottom-0"
              style={{ color: "#2bc5cb26" }}
            >
              <div
                class="h-[30rem] w-full sm:h-[35rem] md:h-full md:w-[1200px] lg:h-[25rem] lg:w-full"
              >
                <svg
                  viewBox="0 0 390 404"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                  class="md:hidden"
                >
                  <path
                    d="M275.976 29.8289C415.87 -15.4099 530.409 -14.996 575 71.7431L558.388 403.5L-86 403.5L-86 22.8329C-16.0529 102.412 136.082 75.0676 275.976 29.8289Z"
                    fill="currentColor"
                  ></path>
                </svg>
                <svg
                  viewBox="0 0 1440 498"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                  class="hidden md:block"
                >
                  <path
                    d="M815 68.2299C1135 -35.2328 1397 -34.2862 1499 164.089L1461 498L-13 498L-13 52.2298C147 234.23 495 171.693 815 68.2299Z"
                    fill="currentColor"
                  ></path>
                </svg>
              </div>
            </div>
            <div class="relative mx-auto max-w-6xl">
              <div class="mx-auto max-w-lg text-center">
                <h2
                  id="section-designed-for-shippers-title"
                  class="text-2xl font-bold leading-tight lg:text-3xl undefined"
                >

                </h2>
                <h3 id="section-designed-for-shippers-sub-title" class="mt-3">

                </h3>
              </div>
              <div class="mt-10">
                <ul class="flex justify-around">
                  <li>
                    <button
                      class="flex flex-col items-center gap-2 rounded-full pr-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent sm:flex-col lg:flex-row lg:gap-4"
                    >
                      <div
                        class="flex h-14 w-14 items-center justify-center rounded-full"
                        style={{ background: "#cb0f511a", color: "#cb0f51" }}
                      >
                        <svg
                          viewBox="0 0 22 26"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6"
                          role="presentation"
                        >
                          <path
                            d="M19.5556 22.7773V9.3329H2.44444V22.7773H19.5556ZM15.8889 0.777344H18.3333V3.22179H19.5556C20.2039 3.22179 20.8256 3.47933 21.284 3.93775C21.7425 4.39617 22 5.01793 22 5.66623V22.7773C22 23.4256 21.7425 24.0474 21.284 24.5058C20.8256 24.9642 20.2039 25.2218 19.5556 25.2218H2.44444C1.08778 25.2218 0 24.1218 0 22.7773V5.66623C0 4.30957 1.08778 3.22179 2.44444 3.22179H3.66667V0.777344H6.11111V3.22179H15.8889V0.777344ZM4.88889 11.7773H7.33333V14.2218H4.88889V11.7773ZM14.6667 11.7773H17.1111V14.2218H14.6667V11.7773ZM9.77778 16.6662H12.2222V19.1107H9.77778V16.6662ZM14.6667 16.6662H17.1111V19.1107H14.6667V16.6662Z"
                            fill="currentColor"
                          ></path>
                        </svg>
                      </div>
                      <div
                        class="text-center text-[0.5625rem] false lg:flex lg:flex-col lg:items-center lg:gap-1 lg:text-base lg:font-semibold svelte-2y4ya6"
                      >
                        <span class="sm:mt-2.5">Occasional</span>
                        <span
                          class="h-1.5 w-20 invisible"
                          style={{ background: "#cb0f51" }}
                        ></span>
                      </div>
                    </button>
                  </li>
                  <li>
                    <button
                      class="flex flex-col items-center gap-2 rounded-full pr-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent sm:flex-row sm:gap-4"
                    >
                      <div
                        class="flex h-14 w-14 items-center justify-center rounded-full"
                        style={{ background: "#2bc5cb26", color: "#2bc5cb" }}
                      >
                        <svg
                          viewBox="0 0 24 21"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6"
                          role="presentation"
                        >
                          <path
                            d="M4.8 18.6667H7.2V21H4.8V18.6667ZM12 0L0 5.83333V21H2.4V11.6667H21.6V21H24V5.83333L12 0ZM7.2 9.33333H2.4V7H7.2V9.33333ZM14.4 9.33333H9.6V7H14.4V9.33333ZM21.6 9.33333H16.8V7H21.6V9.33333ZM4.8 14H7.2V16.3333H4.8V14ZM9.6 14H12V16.3333H9.6V14ZM9.6 18.6667H12V21H9.6V18.6667ZM14.4 18.6667H16.8V21H14.4V18.6667Z"
                            fill="currentColor"
                          ></path>
                        </svg>
                      </div>
                      <div
                        class="text-center text-[0.5625rem] font-semibold sm:flex sm:flex-col sm:items-center sm:gap-1 sm:text-base lg:flex lg:flex-col lg:items-center lg:gap-1 lg:text-base lg:font-semibold svelte-2y4ya6"
                      >
                        <span class="sm:mt-2.5">Small Business</span>
                        <span
                          class="h-1.5 w-20 sm:visible"
                          style={{ background: "#2bc5cb" }}
                        ></span>
                      </div>
                    </button>
                  </li>
                  <li>
                    <button
                      class="flex flex-col items-center gap-2 rounded-full pr-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent sm:flex-col lg:flex-row lg:gap-4"
                    >
                      <div
                        class="flex h-14 w-14 items-center justify-center rounded-full"
                        style={{ background: "#623ec71a", color: "#623ec7" }}
                      >
                        <svg
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6"
                          role="presentation"
                        >
                          <path
                            d="M19.2 19.2C19.8365 19.2 20.447 19.4529 20.8971 19.9029C21.3471 20.353 21.6 20.9635 21.6 21.6C21.6 22.2365 21.3471 22.847 20.8971 23.2971C20.447 23.7471 19.8365 24 19.2 24C17.868 24 16.8 22.92 16.8 21.6C16.8 20.268 17.868 19.2 19.2 19.2ZM0 0H3.924L5.052 2.4H22.8C23.1183 2.4 23.4235 2.52643 23.6485 2.75147C23.8736 2.97652 24 3.28174 24 3.6C24 3.804 23.94 4.008 23.856 4.2L19.56 11.964C19.152 12.696 18.36 13.2 17.46 13.2H8.52L7.44 15.156L7.404 15.3C7.404 15.3796 7.43561 15.4559 7.49187 15.5121C7.54813 15.5684 7.62444 15.6 7.704 15.6H21.6V18H7.2C5.868 18 4.8 16.92 4.8 15.6C4.8 15.18 4.908 14.784 5.088 14.448L6.72 11.508L2.4 2.4H0V0ZM7.2 19.2C7.83652 19.2 8.44697 19.4529 8.89706 19.9029C9.34714 20.353 9.6 20.9635 9.6 21.6C9.6 22.2365 9.34714 22.847 8.89706 23.2971C8.44697 23.7471 7.83652 24 7.2 24C5.868 24 4.8 22.92 4.8 21.6C4.8 20.268 5.868 19.2 7.2 19.2ZM18 10.8L21.336 4.8H6.168L9 10.8H18Z"
                            fill="currentColor"
                          ></path>
                        </svg>
                      </div>
                      <div
                        class="text-center text-[0.5625rem] false lg:flex lg:flex-col lg:items-center lg:gap-1 lg:text-base lg:font-semibold svelte-2y4ya6"
                      >
                        <span class="sm:mt-2.5">E-commerce</span>
                        <span
                          class="h-1.5 w-20 invisible"
                          style={{ background: "#623ec7" }}
                        ></span>
                      </div>
                    </button>
                  </li>
                  <li>
                    <button
                      class="flex flex-col items-center gap-2 rounded-full pr-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent sm:flex-col lg:flex-row lg:gap-4"
                    >
                      <div
                        class="flex h-14 w-14 items-center justify-center rounded-full"
                        style={{ background: "#ffa43c26", color: "#ffa43c" }}
                      >
                        <svg
                          viewBox="0 0 11 22"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6"
                          role="presentation"
                        >
                          <path
                            d="M0 0V12.1H3.3V22L11 8.8H6.6L11 0H0Z"
                            fill="currentColor"
                          ></path>
                        </svg>
                      </div>
                      <div
                        class="text-center text-[0.5625rem] false lg:flex lg:flex-col lg:items-center lg:gap-1 lg:text-base lg:font-semibold svelte-2y4ya6"
                      >
                        <span class="sm:mt-2.5">Power User</span>
                        <span
                          class="h-1.5 w-20 invisible"
                          style={{ background: "#ffa43c" }}
                        ></span>
                      </div>
                    </button>
                  </li>
                  <li>
                    <button
                      class="flex flex-col items-center gap-2 rounded-full pr-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent sm:flex-col lg:flex-row lg:gap-4"
                    >
                      <div
                        class="flex h-14 w-14 items-center justify-center rounded-full"
                        style={{ background: "#589bff26", color: "#589bff" }}
                      >
                        <svg
                          viewBox="0 0 24 21"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6"
                          role="presentation"
                        >
                          <path
                            d="M18.6667 14H16.3333V16.3333H18.6667M18.6667 9.33333H16.3333V11.6667H18.6667M21 18.6667H11.6667V16.3333H14V14H11.6667V11.6667H14V9.33333H11.6667V7H21M9.33333 4.66667H7V2.33333H9.33333M9.33333 9.33333H7V7H9.33333M9.33333 14H7V11.6667H9.33333M9.33333 18.6667H7V16.3333H9.33333M4.66667 4.66667H2.33333V2.33333H4.66667M4.66667 9.33333H2.33333V7H4.66667M4.66667 14H2.33333V11.6667H4.66667M4.66667 18.6667H2.33333V16.3333H4.66667M11.6667 4.66667V0H0V21H23.3333V4.66667H11.6667Z"
                            fill="currentColor"
                          ></path>
                        </svg>
                      </div>
                      <div
                        class="text-center text-[0.5625rem] false lg:flex lg:flex-col lg:items-center lg:gap-1 lg:text-base lg:font-semibold svelte-2y4ya6"
                      >
                        <span class="sm:mt-2.5">Enterprise</span>
                        <span
                          class="h-1.5 w-20 invisible"
                          style={{ background: "#589bff" }}
                        ></span>
                      </div>
                    </button>
                  </li>
                </ul>
                <div class="mt-8">
                  <div class="flex flex-col items-center sm:hidden">
                    <h2 class="text-lg font-semibold">Small Business</h2>
                    <div class="h-1.5 w-20" style={{ background: "#2bc5cb" }}></div>
                  </div>
                  <div class="tab-content grid grid-cols-3 gap-4 svelte-2y4ya6">
                    <div
                      class="tab-content__slider -mx-4 mt-8 min-h-[17rem] lg:mx-0 svelte-2y4ya6"
                    ></div>
                    <button
                      id="swiper-button-prev"
                      class="action-button tab-content__previous-button justify-self-center svelte-2y4ya6"
                      aria-label="Show previous item"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5"
                        aria-hidden="true"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                    </button>
                    <button
                      class="action-button tab-content__pause-button justify-self-center svelte-2y4ya6"
                      style={{ color: "#2bc5cb" }}
                      aria-label="Pause auto item switching"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5"
                        aria-hidden="true"
                      >
                        <path
                          d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"
                        ></path>
                      </svg>
                    </button>
                    <button
                      id="swiper-button-next"
                      class="action-button tab-content__next-button justify-self-center svelte-2y4ya6"
                      aria-label="Show next item"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5"
                        aria-hidden="true"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                    </button>
                    <div
                      class="tab-content__description relative mx-auto mt-3 min-h-[10rem] max-w-lg sm:min-h-[8rem] svelte-2y4ya6"
                    >
                      <p
                        class="rounded-xl bg-white px-8 py-4 text-center shadow-[0px_8px_40px_rgba(0,_0,_0,_0.1)]"
                        aria-label="Track: Full tracking information directly from the carrier."
                      >
                        <span class="font-semibold">Track:</span> Full tracking
                        information directly from the carrier.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <div class="relative mx-auto max-w-6xl mt-6 sm:pt-10">
            <section
              class="flex flex-col gap-4 px-4 py-8 sm:items-center md:gap-8 lg:gap-16 lg:px-8 lg:py-12 sm:flex-row undefined"
              aria-labelledby="easiest-shipping-platform"
            >
              <div class="space-y-3 sm:w-1/2">
                <h2
                  id="easiest-shipping-platform"
                  class="text-2xl font-bold leading-tight lg:text-3xl max-w-md false"
                >
                  The world's easiest shipping platform
                </h2>
                <h3 class="max-w-md">
                  Easy. Simple Awesome. This intuitively easy shipping platform
                  allows you to do all things shipping - ship, track, compare
                  prices, schedule pickups, and more!
                </h3>
              </div>
              <img
                src="_app/immutable/assets/easiest-platform.BArRDPBv.svg"
                alt="The world's easiest shipping platform"
                class="w-full sm:w-1/2"
              />
            </section>
            <section
              class="flex flex-col gap-4 px-4 py-8 sm:items-center md:gap-8 lg:gap-16 lg:px-8 lg:py-12 sm:flex-row-reverse undefined"
              aria-labelledby="ship-with-confidence"
            >
              <div class="space-y-3 sm:w-1/2">
                <h2
                  id="ship-with-confidence"
                  class="text-2xl font-bold leading-tight lg:text-3xl max-w-md false"
                >
                  Ship with confidence
                </h2>
                <h3 class="max-w-md">
                  Our built-in advisor can help you reduce 91% of preventable
                  issues while guiding you through some of the complexities of
                  shipping.
                </h3>
              </div>
              <img
                src="_app/immutable/assets/ship-with-confidence.Dy6wH2qI.svg"
                alt="Ship with confidence"
                class="w-full sm:w-1/2"
              />
            </section>
            <section
              class="flex flex-col gap-4 px-4 py-8 sm:items-center md:gap-8 lg:gap-16 lg:px-8 lg:py-12 sm:flex-row undefined"
              aria-labelledby="focus-on-growth"
            >
              <div class="space-y-3 sm:w-1/2">
                <h2
                  id="focus-on-growth"
                  class="text-2xl font-bold leading-tight lg:text-3xl max-w-md false"
                >
                  Focus on growth. Not shipping.
                </h2>
                <h3 class="max-w-md">
                  Packed with powerful features and automations, you'll spend less
                  time shipping and more time on things that matter to you - like
                  growth!
                </h3>
              </div>
              <img
                src="_app/immutable/assets/focus-on-growth.-XtYNJmp.svg"
                alt="Focus on growth. Not shipping."
                class="w-full sm:w-1/2"
              />
            </section>
            <section
              class="flex flex-col gap-4 px-4 py-8 sm:items-center md:gap-8 lg:gap-16 lg:px-8 lg:py-12 sm:flex-row-reverse undefined"
              aria-labelledby="supercharge-shipping"
            >
              <div class="space-y-3 sm:w-1/2">
                <h2
                  id="supercharge-shipping"
                  class="text-2xl font-bold leading-tight lg:text-3xl max-w-md false"
                >
                  Supercharge your shipping
                </h2>
                <h3 class="max-w-md">
                  Leverage the power of Secureship's shipping platform with your
                  own carrier accounts.
                </h3>
              </div>
              <img
                src="_app/immutable/assets/supercharge-shipping.B7eipl1o.svg"
                alt="Supercharge your shipping"
                class="w-full sm:w-1/2"
              />
            </section>
          </div>
          <div class="relative overflow-hidden pb-10 mt-6 sm:pt-5">
            <div class="absolute left-0 right-0 top-0 h-1/2 bg-[#DAD9FF]"></div>
            <div class="absolute bottom-0 left-0 right-0 text-[#DAD9FF]">
              <svg
                viewBox="0 0 390 1096"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="sm:hidden"
                aria-hidden="true"
              >
                <path
                  d="M180.286 1077.41C92.6667 1105.6 20.9286 1105.34 -7 1051.3L3.40476 0H407V1081.77C363.19 1032.19 267.905 1049.23 180.286 1077.41Z"
                  fill="url(#6kh5cmq1)"
                ></path>
                <defs>
                  <linearGradient
                    id="6kh5cmq1"
                    x1="312"
                    y1="577.268"
                    x2="312"
                    y2="928.182"
                    gradientUnits="userSpaceOnUse"
                  >
                    <stop stop-color="currentColor"></stop>
                    <stop offset="1" stop-color="currentColor"></stop>
                  </linearGradient>
                </defs>
              </svg>
              <svg
                viewBox="0 0 768 870"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="hidden sm:block"
                aria-hidden="true"
              >
                <path
                  d="M307.071 831.654C127.389 889.81 -19.7262 889.278 -77 777.771L-55.6627 0H772V840.647C682.159 738.346 486.754 773.498 307.071 831.654Z"
                  fill="url(#bpyl1z31)"
                ></path>
                <defs>
                  <linearGradient
                    id="bpyl1z31"
                    x1="347.5"
                    y1="440.434"
                    x2="347.5"
                    y2="872.687"
                    gradientUnits="userSpaceOnUse"
                  >
                    <stop stop-color="currentColor"></stop>
                    <stop offset="1" stop-color="currentColor"></stop>
                  </linearGradient>
                </defs>
              </svg>
            </div>
            <section
              class="relative mx-auto max-w-6xl px-4 py-8 sm:px-8"
              aria-labelledby="automate-everything-title"
            >
              <h2
                id="automate-everything-title"
                class="text-2xl font-bold leading-tight lg:text-3xl undefined"
              >
                Automate. Everything.
              </h2>
              <h3 id="automate-everything-sub-title" class="mt-1">
                Spend less time shipping with our powerful automations.
              </h3>
              <ul class="mt-4 space-y-1.5">
                <li class="flex items-center gap-4">
                  <div
                    class="grid place-content-center rounded-full bg-white p-2"
                  >
                    <svg
                      class="h-6 w-6"
                      viewBox="0 0 25 25"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                      role="presentation"
                    >
                      <path
                        d="M23.5849 7.277C24.5283 8.21596 24.5283 9.74178 23.5849 10.5634L20.283 13.8498L11.0849 4.69484L14.3868 1.40845C15.3302 0.469484 16.8632 0.469484 17.6887 1.40845L19.8113 3.52113L23.3491 0L25 1.64319L21.4623 5.16432L23.5849 7.277ZM16.7453 14.0845L15.0943 12.4413L11.7925 15.7277L9.31604 13.2629L12.6179 9.97653L10.967 8.33333L7.66509 11.6197L5.89623 9.97653L2.59434 13.2629C1.65094 14.2019 1.65094 15.7277 2.59434 16.5493L4.71698 18.662L0 23.3568L1.65094 25L6.36792 20.3052L8.49057 22.4178C9.43396 23.3568 10.967 23.3568 11.7925 22.4178L15.0943 19.1315L13.4434 17.4883L16.7453 14.0845Z"
                        fill="#36134A"
                      ></path>
                    </svg>
                  </div>
                  <p class="text-xl font-semibold">Marketplace plugins</p>
                </li>
                <li class="flex items-center gap-4">
                  <div
                    class="grid place-content-center rounded-full bg-white p-2"
                  >
                    <svg
                      class="h-6 w-6"
                      viewBox="0 0 21 18"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                      role="presentation"
                    >
                      <path
                        d="M11.31 0L13.27 0.4L9.53 18L7.57 17.6L11.31 0ZM18.01 9L14.42 5.41V2.58L20.84 9L14.42 15.41V12.58L18.01 9ZM0 9L6.42 2.58V5.41L2.83 9L6.42 12.58V15.41L0 9Z"
                        fill="#36134A"
                      ></path>
                    </svg>
                  </div>
                  <p class="text-xl font-semibold">
                    The world's most easy-to-use shipping API
                  </p>
                </li>
              </ul>
              <section
                class="rounded-2xl bg-secondary px-4 py-6 text-white sm:px-6 mt-8"
                aria-labelledby="designed-for-developers-title"
              >
                <h2
                  id="designed-for-developers-title"
                  class="mb-2 text-xl font-semibold leading-tight"
                >
                  Designed for developers
                </h2>
                <div class="mt-5 hidden grid-cols-[1fr_1.8fr] lg:grid">
                  <ul>
                    <li>
                      <button
                        class="w-full rounded-bl-xl rounded-tl-xl px-3 py-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent bg-white text-primary"
                      >
                        <div class="flex items-center gap-4">
                          <svg
                            viewBox="0 0 31 23"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-accent"
                          >
                            <path
                              d="M0 4.8764H13.5843L14.6292 6.96629H1.04494L0 4.8764ZM1.39326 9.05618H14.9775L16.0225 11.1461H2.4382L1.39326 9.05618ZM24.0337 20.2022C25.1901 20.2022 26.1236 19.2688 26.1236 18.1124C26.1236 16.956 25.1901 16.0225 24.0337 16.0225C22.8773 16.0225 21.9438 16.956 21.9438 18.1124C21.9438 19.2688 22.8773 20.2022 24.0337 20.2022ZM26.1236 7.66292H22.6404V11.1461H28.8544L26.1236 7.66292ZM10.1011 20.2022C11.2575 20.2022 12.191 19.2688 12.191 18.1124C12.191 16.956 11.2575 16.0225 10.1011 16.0225C8.94472 16.0225 8.01124 16.956 8.01124 18.1124C8.01124 19.2688 8.94472 20.2022 10.1011 20.2022ZM26.8202 5.57303L31 11.1461V18.1124H28.2135C28.2135 20.4252 26.3465 22.2921 24.0337 22.2921C21.7209 22.2921 19.8539 20.4252 19.8539 18.1124H14.2809C14.2809 20.4252 12.4 22.2921 10.1011 22.2921C7.78831 22.2921 5.92135 20.4252 5.92135 18.1124H3.13483V13.236H5.92135V15.3258H6.98023C7.74652 14.476 8.86112 13.9326 10.1011 13.9326C11.3411 13.9326 12.4557 14.476 13.222 15.3258H19.8539V2.78652H3.13483C3.13483 1.24 4.37483 0 5.92135 0H22.6404V5.57303H26.8202Z"
                              fill="currentColor"
                            ></path>
                          </svg>
                          <span class="text-lg font-semibold">Carrier API </span>
                        </div>
                        <p class="mt-2 text-left text-sm text-primary-light">
                          Get rates, track packages, create labels, this API will
                          let you interact directly with the carrier. You can use
                          Secureship's discounted rates account or use your own
                          account.
                        </p>
                      </button>
                    </li>
                    <li>
                      <button
                        class="w-full rounded-bl-xl rounded-tl-xl px-3 py-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent transition hover:bg-primary-dark"
                      >
                        <div class="flex items-center gap-4">
                          <svg
                            viewBox="0 0 32 30"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-accent"
                          >
                            <path
                              d="M18.1998 21.5767C17.4998 21.7711 16.5998 21.9655 15.6998 21.9655C14.7998 21.9655 13.9998 21.8683 13.1998 21.5767C12.6998 21.4795 12.3998 21.9655 12.6998 22.3542C13.3998 23.229 14.4998 23.7149 15.6998 23.7149C16.8998 23.7149 17.9998 23.1318 18.6998 22.3542C18.9998 21.9655 18.5998 21.3823 18.1998 21.5767Z"
                              fill="currentColor"
                            ></path>
                            <path
                              d="M4.4 18.8553L5.8 19.3412V17.9805L6.7 18.3693L5.1 15.8423L3.5 17.1058L4.4 17.3974V18.8553Z"
                              fill="currentColor"
                            ></path>
                            <path
                              d="M3.5 20.1189L6.7 21.3824V20.6048L3.5 19.3413V20.1189Z"
                              fill="currentColor"
                            ></path>
                            <path
                              d="M15.7 0L0 6.31752V22.9375L15.7 29.255L31.4 22.9375V6.22033L15.7 0ZM27.3 6.90067L22.8 8.74733L11.2 4.08209L15.7 2.23543L27.3 6.90067ZM21.3 9.33049L15.7 11.5659L4.1 6.90067L9.7 4.66524L21.3 9.33049ZM15.7 26.728L2.2 21.2852V8.55295L15.7 13.9957L29.2 8.55295V21.3824L15.7 26.728Z"
                              fill="currentColor"
                            ></path>
                            <path
                              d="M14.2004 17.6891C14.1004 16.4256 13.1004 15.3564 11.8004 15.3564C10.5004 15.3564 9.40039 16.4256 9.40039 17.6891C9.40039 18.9526 10.5004 19.3413 11.8004 19.6329C13.3004 20.1189 14.2004 19.0498 14.2004 17.6891Z"
                              fill="currentColor"
                            ></path>
                            <path
                              d="M17.3005 17.6891C17.4005 16.4256 18.4005 15.3564 19.7005 15.3564C21.0005 15.3564 22.1005 16.4256 22.1005 17.6891C22.1005 18.9526 21.0005 19.3413 19.7005 19.6329C18.1005 20.1189 17.2005 19.0498 17.3005 17.6891Z"
                              fill="currentColor"
                            ></path>
                          </svg>
                          <span class="text-lg font-semibold"
                          >Secureship API
                          </span>
                        </div>
                        <p class="mt-2 text-left text-sm text-primary-light">
                          Access your History, Address Book, Parts book, and
                          anything available through the Secureship Platform via
                          this API.
                        </p>
                      </button>
                    </li>
                  </ul>
                  <div class="h-full overflow-hidden rounded-br-xl rounded-tr-xl">
                    <div
                      class="rounded-bl-xl flex min-h-[30rem] flex-col gap-4 bg-white px-4 py-6 text-primary md:flex-col-reverse md:justify-end md:px-6"
                    >
                      <figure
                        aria-labelledby="banner-carrier-api-caption"
                        class="-mx-3 sm:mx-5"
                      >
                        <picture
                        ><source
                            type="image/avif"
                            srcset="
                            /_app/immutable/assets/carrier-api.CC3-hsha.avif 480w
                          " />
                          <source
                            type="image/webp"
                            srcset="
                            /_app/immutable/assets/carrier-api.8hlBZV7E.webp 480w
                          " />
                          <img
                            loading="lazy"
                            decoding="async"
                            width="480"
                            height="316"
                            alt="some text"
                            class="w-full rounded-lg"
                            src="_app/immutable/assets/carrier-api.DSWVgwLu.jpg"
                            style={{
                              background: "url(data:image/webp;base64,UklGRnwAAABXRUJQVlA4WAoAAAAQAAAADwAACgAAQUxQSDwAAAABZ2CmbRv+aHvuykwjIgJN9W5QFElOlMPA4QAnkYAE/KBgcYAShCUvFET0fwKUqi3q8r/wOia1lvsAwH1WUDggGgAAADABAJ0BKhAACwAFQHwlpAADcAD+7zJMgAAA) no-repeat center/cover"
                            }}
                          /></picture>
                        <figcaption
                          id="banner-carrier-api-caption"
                          class="sr-only"
                        >
                          some text
                        </figcaption>
                      </figure>
                      <div
                        class="text-center text-primary mt-4 lg:ml-auto lg:mt-0"
                      >
                        <a
                          href="ship/api/docs.html"
                          rel="noopener noreferrer"
                          target="_blank"
                          data-sveltekit-reload
                          class="flex items-center justify-center gap-2 font-semibold"
                        ><span>Read Documentation</span>
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            class="mb-1 me-2 h-5 w-5"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                              clip-rule="evenodd"
                            ></path></svg
                          ></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="lg:hidden">
                  <div class="my-3 rounded-lg">
                    <button
                      id="headlessui-disclosure-button-1933"
                      type="button"
                      aria-expanded
                      class="w-full rounded-tl-[inherit] rounded-tr-[inherit] px-3 py-4 bg-white text-primary"
                    >
                      <div class="flex items-center gap-4">
                        <svg
                          viewBox="0 0 31 23"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6 text-accent"
                        >
                          <path
                            d="M0 4.8764H13.5843L14.6292 6.96629H1.04494L0 4.8764ZM1.39326 9.05618H14.9775L16.0225 11.1461H2.4382L1.39326 9.05618ZM24.0337 20.2022C25.1901 20.2022 26.1236 19.2688 26.1236 18.1124C26.1236 16.956 25.1901 16.0225 24.0337 16.0225C22.8773 16.0225 21.9438 16.956 21.9438 18.1124C21.9438 19.2688 22.8773 20.2022 24.0337 20.2022ZM26.1236 7.66292H22.6404V11.1461H28.8544L26.1236 7.66292ZM10.1011 20.2022C11.2575 20.2022 12.191 19.2688 12.191 18.1124C12.191 16.956 11.2575 16.0225 10.1011 16.0225C8.94472 16.0225 8.01124 16.956 8.01124 18.1124C8.01124 19.2688 8.94472 20.2022 10.1011 20.2022ZM26.8202 5.57303L31 11.1461V18.1124H28.2135C28.2135 20.4252 26.3465 22.2921 24.0337 22.2921C21.7209 22.2921 19.8539 20.4252 19.8539 18.1124H14.2809C14.2809 20.4252 12.4 22.2921 10.1011 22.2921C7.78831 22.2921 5.92135 20.4252 5.92135 18.1124H3.13483V13.236H5.92135V15.3258H6.98023C7.74652 14.476 8.86112 13.9326 10.1011 13.9326C11.3411 13.9326 12.4557 14.476 13.222 15.3258H19.8539V2.78652H3.13483C3.13483 1.24 4.37483 0 5.92135 0H22.6404V5.57303H26.8202Z"
                            fill="currentColor"
                          ></path>
                        </svg>
                        <span class="text-lg font-semibold">Carrier API </span>
                      </div>
                      <p class="mt-2 text-left text-sm text-primary-light">
                        Get rates, track packages, create labels, this API will
                        let you interact directly with the carrier. You can use
                        Secureship's discounted rates account or use your own
                        account.
                      </p>
                    </button>
                    <div
                      id="headlessui-disclosure-panel-1934"
                      class="rounded-bl-[inherit] rounded-br-[inherit] bg-white px-3 pb-4"
                    >
                      <div class="text-primary">
                        <div
                          class="rounded-bl-xl flex h-full flex-col gap-4 bg-white px-4 py-6 text-primary"
                        >
                          <figure
                            aria-labelledby="banner-carrier-api-caption"
                            class="-mx-3 sm:mx-5"
                          >
                            <picture
                            ><source
                                type="image/avif"
                                srcset="
                                /_app/immutable/assets/carrier-api.CC3-hsha.avif 480w
                              " />
                              <source
                                type="image/webp"
                                srcset="
                                /_app/immutable/assets/carrier-api.8hlBZV7E.webp 480w
                              " />
                              <img
                                loading="lazy"
                                decoding="async"
                                width="480"
                                height="316"
                                alt="some text"
                                class="w-full rounded-lg"
                                src="_app/immutable/assets/carrier-api.DSWVgwLu.jpg"
                                style={{
                                  background: "url(data:image/webp;base64,UklGRnwAAABXRUJQVlA4WAoAAAAQAAAADwAACgAAQUxQSDwAAAABZ2CmbRv+aHvuykwjIgJN9W5QFElOlMPA4QAnkYAE/KBgcYAShCUvFET0fwKUqi3q8r/wOia1lvsAwH1WUDggGgAAADABAJ0BKhAACwAFQHwlpAADcAD+7zJMgAAA) no-repeat center/cover"
                                }}
                              /></picture>
                            <figcaption
                              id="banner-carrier-api-caption"
                              class="sr-only"
                            >
                              some text
                            </figcaption>
                          </figure>
                          <div
                            class="text-center text-primary mt-4 lg:ml-auto lg:mt-0"
                          >
                            <a
                              href="ship/api/docs.html"
                              rel="noopener noreferrer"
                              target="_blank"
                              data-sveltekit-reload
                              class="flex items-center justify-center gap-2 font-semibold"
                            ><span>Read Documentation</span>
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                class="mb-1 me-2 h-5 w-5"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                  clip-rule="evenodd"
                                ></path></svg
                              ></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="my-3 rounded-lg">
                    <button
                      id="headlessui-disclosure-button-1935"
                      type="button"
                      aria-expanded="false"
                      class="w-full rounded-tl-[inherit] rounded-tr-[inherit] px-3 py-4 rounded-bl-[inherit] rounded-br-[inherit]"
                    >
                      <div class="flex items-center gap-4">
                        <svg
                          viewBox="0 0 32 30"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6 text-accent"
                        >
                          <path
                            d="M18.1998 21.5767C17.4998 21.7711 16.5998 21.9655 15.6998 21.9655C14.7998 21.9655 13.9998 21.8683 13.1998 21.5767C12.6998 21.4795 12.3998 21.9655 12.6998 22.3542C13.3998 23.229 14.4998 23.7149 15.6998 23.7149C16.8998 23.7149 17.9998 23.1318 18.6998 22.3542C18.9998 21.9655 18.5998 21.3823 18.1998 21.5767Z"
                            fill="currentColor"
                          ></path>
                          <path
                            d="M4.4 18.8553L5.8 19.3412V17.9805L6.7 18.3693L5.1 15.8423L3.5 17.1058L4.4 17.3974V18.8553Z"
                            fill="currentColor"
                          ></path>
                          <path
                            d="M3.5 20.1189L6.7 21.3824V20.6048L3.5 19.3413V20.1189Z"
                            fill="currentColor"
                          ></path>
                          <path
                            d="M15.7 0L0 6.31752V22.9375L15.7 29.255L31.4 22.9375V6.22033L15.7 0ZM27.3 6.90067L22.8 8.74733L11.2 4.08209L15.7 2.23543L27.3 6.90067ZM21.3 9.33049L15.7 11.5659L4.1 6.90067L9.7 4.66524L21.3 9.33049ZM15.7 26.728L2.2 21.2852V8.55295L15.7 13.9957L29.2 8.55295V21.3824L15.7 26.728Z"
                            fill="currentColor"
                          ></path>
                          <path
                            d="M14.2004 17.6891C14.1004 16.4256 13.1004 15.3564 11.8004 15.3564C10.5004 15.3564 9.40039 16.4256 9.40039 17.6891C9.40039 18.9526 10.5004 19.3413 11.8004 19.6329C13.3004 20.1189 14.2004 19.0498 14.2004 17.6891Z"
                            fill="currentColor"
                          ></path>
                          <path
                            d="M17.3005 17.6891C17.4005 16.4256 18.4005 15.3564 19.7005 15.3564C21.0005 15.3564 22.1005 16.4256 22.1005 17.6891C22.1005 18.9526 21.0005 19.3413 19.7005 19.6329C18.1005 20.1189 17.2005 19.0498 17.3005 17.6891Z"
                            fill="currentColor"
                          ></path>
                        </svg>
                        <span class="text-lg font-semibold">Secureship API </span>
                      </div>
                      <p class="mt-2 text-left text-sm text-primary-light">
                        Access your History, Address Book, Parts book, and
                        anything available through the Secureship Platform via
                        this API.
                      </p>
                    </button>
                  </div>
                </div>
              </section>
            </section>
          </div>
          <section
            class="relative mx-auto max-w-6xl mt-6 svelte-16vond3"
            aria-labelledby="testimonial-section-title"
          >
            <h2
              id="testimonial-section-title"
              class="text-2xl font-bold leading-tight lg:text-3xl text-center"
            >
              Very happy customers
            </h2>
            <h3
              id="testimonial-section-sub-title"
              class="mt-1 text-center text-primary-light sm:mt-2"
            >
              See what others are saying
            </h3>
            <div class="mt-8 md:mx-auto md:max-w-4xl">
              <div
                class="grid grid-cols-1 gap-8 px-4 sm:grid-cols-2 sm:grid-rows-[1fr_auto] lg:px-0"
              >
                <div
                  class="flex flex-col gap-4 rounded-2xl bg-white p-4 shadow-md undefined"
                >
                  <div class="flex items-center gap-3">
                    <picture
                    ><source
                        type="image/avif"
                        srcset="
                        /_app/immutable/assets/hana-pika.B1CDsSmc.avif 60w
                      " />
                      <source
                        type="image/webp"
                        srcset="
                        /_app/immutable/assets/hana-pika.AFdoc6pE.webp 60w
                      " />
                      <img
                        loading="lazy"
                        decoding="async"
                        width="60"
                        height="60"
                        alt="Hana Pika"
                        aria-hidden="true"
                        class="h-12 w-12 rounded-full object-cover"
                        src="_app/immutable/assets/hana-pika.Bth8aRGH.jpg"

                      /></picture>
                    <div>
                      <div class="font-semibold">Hana Pika</div>
                      <div class="text-xs text-primary-light">
                        CIO &amp; VP of IT
                      </div>
                    </div>
                    <a
                      href="https://www.ottawaheart.ca/"
                      target="_blank"
                      class="ml-auto"
                    ><picture
                    ><source
                          type="image/avif"
                          srcset="
                          /_app/immutable/assets/hana-pika-company.BpkB9Nl9.avif 214w
                        " />
                        <source
                          type="image/webp"
                          srcset="
                          /_app/immutable/assets/hana-pika-company.QUQZLx8W.webp 214w
                        " />
                        <img
                          loading="lazy"
                          decoding="async"
                          width="214"
                          height="100"
                          alt=""
                          aria-hidden="true"
                          class="h-16 w-auto"
                          src="_app/immutable/assets/hana-pika-company.DtKT40mJ.jpg"
                        /></picture
                      ></a>
                  </div>
                  <p class="line-clamp-[9] text-sm">
                    Secureship not only improved the efficiency of our shipping
                    but also reduced our overall costs. Add in top-notch customer
                    service and in-depth shipping expertise and our shipping
                    experience has dramatically improved since switching to Secure
                    ship!
                  </p>
                </div>
                <div
                  class="flex flex-col gap-4 rounded-2xl bg-white p-4 shadow-md undefined"
                >
                  <div class="flex items-center gap-3">
                    <picture
                    ><source
                        type="image/avif"
                        srcset="
                        /_app/immutable/assets/dean-smith.DGWbDAJZ.avif 60w
                      " />
                      <source
                        type="image/webp"
                        srcset="
                        /_app/immutable/assets/dean-smith.-mVrndED.webp 60w
                      " />
                      <img
                        loading="lazy"
                        decoding="async"
                        width="60"
                        height="60"
                        alt="Dean Smith"
                        aria-hidden="true"
                        class="h-12 w-12 rounded-full object-cover"
                        src="_app/immutable/assets/dean-smith.B7Ul08iZ.jpg"
                        style={{
                          background: "url(data:image/webp;base64,UklGRloAAABXRUJQVlA4IE4AAADQAQCdASoQABAABUB8JaACdAEYEC6DAAD+jSvfQ3qhYIdhaEM/5CIHPysA/9veCvgAYfyPv+Jmapkb8VgP1O1ZM4hTuGD5BvY+7kHAAAA=) no-repeat center/cover"
                        }}
                      /></picture>
                    <div>
                      <div class="font-semibold">Dean Smith</div>
                      <div class="text-xs text-primary-light">
                        Manager, Information Technology
                      </div>
                    </div>
                    <a
                      href="https://www.cda-adc.ca/"
                      target="_blank"
                      class="ml-auto"
                    ><picture
                    ><source
                          type="image/avif"
                          srcset="
                          /_app/immutable/assets/dean-smith-company.DOhd0Q8Q.avif 214w
                        " />
                        <source
                          type="image/webp"
                          srcset="
                          /_app/immutable/assets/dean-smith-company.D1VrQ_I5.webp 214w
                        " />
                        <img
                          loading="lazy"
                          decoding="async"
                          width="214"
                          height="100"
                          alt=""
                          aria-hidden="true"
                          class="h-16 w-auto"
                          src="_app/immutable/assets/dean-smith-company.CXRA4K6Q.jpg"
                        /></picture
                      ></a>
                  </div>
                  <p class="line-clamp-[9] text-sm">
                    Secureship has reduced our costs and saved us a great deal of
                    time. We no longer have to visit multiple websites to compare
                    costs and everything is tracked from one location. The Secure
                    ship team provides valuable customer support allowing our team
                    to focus on our core business.
                  </p>
                </div>
                <div
                  class="flex flex-col gap-4 rounded-2xl bg-white p-4 shadow-md undefined"
                >
                  <div class="flex items-center gap-3">
                    <picture
                    ><source
                        type="image/avif"
                        srcset="
                        /_app/immutable/assets/mike-kelland.mr-F7WWa.avif 60w
                      " />
                      <source
                        type="image/webp"
                        srcset="
                        /_app/immutable/assets/mike-kelland.CAf1YuyH.webp 60w
                      " />
                      <img
                        loading="lazy"
                        decoding="async"
                        width="60"
                        height="60"
                        alt="Mike Kelland"
                        aria-hidden="true"
                        class="h-12 w-12 rounded-full object-cover"
                        src="_app/immutable/assets/mike-kelland.CNhMZskK.jpg"

                      /></picture>
                    <div>
                      <div class="font-semibold">Mike Kelland</div>
                      <div class="text-xs text-primary-light">
                        President &amp; CEO
                      </div>
                    </div>
                    <a
                      href="https://boldradius.com/"
                      target="_blank"
                      class="ml-auto"
                    ><picture
                    ><source
                          type="image/avif"
                          srcset="
                          /_app/immutable/assets/mike-kelland-company.Dfx5KCJJ.avif 213w
                        " />
                        <source
                          type="image/webp"
                          srcset="
                          /_app/immutable/assets/mike-kelland-company.CkTqjB4F.webp 213w
                        " />
                        <img
                          loading="lazy"
                          decoding="async"
                          width="213"
                          height="100"
                          alt=""
                          aria-hidden="true"
                          class="h-16 w-auto"
                          src="_app/immutable/assets/mike-kelland-company.CILNakzj.jpg"
                        /></picture
                      ></a>
                  </div>
                  <p class="line-clamp-[9] text-sm">
                    Simply amazing! Secureship made shipping super simple and
                    slick - love it!
                  </p>
                </div>
                <div
                  class="flex flex-col gap-4 rounded-2xl bg-white p-4 shadow-md undefined"
                >
                  <div class="flex items-center gap-3">
                    <picture
                    ><source
                        type="image/avif"
                        srcset="
                        /_app/immutable/assets/kat-gracie.B6iMAvw4.avif 200w
                      " />
                      <source
                        type="image/webp"
                        srcset="
                        /_app/immutable/assets/kat-gracie.BGvJGja8.webp 200w
                      " />
                      <img
                        loading="lazy"
                        decoding="async"
                        width="200"
                        height="200"
                        alt="Kat Gracie"
                        aria-hidden="true"
                        class="h-12 w-12 rounded-full object-cover"
                        src="_app/immutable/assets/kat-gracie.Bvk2r9mD.jpg"
                        style={{
                          background: "url(data:image/webp;base64,UklGRl4AAABXRUJQVlA4IFIAAABwAgCdASoQABAABUB8JYwC7AEXtNz2JnYQqGNAAP7v4D7xt4eSR6lejWttE4WZ8Ipw15vl2GkMO4tdi436QB3vn7DYxTKoh9ur0P1ttBgURmQA) no-repeat center/cover"
                        }}
                      /></picture>
                    <div>
                      <div class="font-semibold">Kat Gracie</div>
                      <div class="text-xs text-primary-light">
                        Marketing Events Manager
                      </div>
                    </div>
                    <a
                      href="https://www.ssidirect.ca/"
                      target="_blank"
                      class="ml-auto"
                    ><picture
                    ><source
                          type="image/avif"
                          srcset="
                          /_app/immutable/assets/kat-gracie-company.Cn2l-2JD.avif 214w
                        " />
                        <source
                          type="image/webp"
                          srcset="
                          /_app/immutable/assets/kat-gracie-company.BAQK69aG.webp 214w
                        " />
                        <img
                          loading="lazy"
                          decoding="async"
                          width="214"
                          height="100"
                          alt=""
                          aria-hidden="true"
                          class="h-16 w-auto"
                          src="_app/immutable/assets/kat-gracie-company.DijjyTUv.jpg"
                        /></picture
                      ></a>
                  </div>
                  <p class="line-clamp-[9] text-sm">
                    Shipping across borders can get tricky, but when we work with
                    Secureship I feel confident. If you value cost savings and
                    excellent service, Secureship goes above and beyond. I highly
                    recommend them.
                  </p>
                </div>
              </div>
              <div class="mt-10 grid place-items-center">
                <a
                  href="testimonials.html"
                  target=""
                  class="flex items-center gap-2 font-semibold sm:ml-8"
                  data-sveltekit-reload
                ><span class="underline underline-offset-8">More reviews</span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    class="h-6 w-6"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                      clip-rule="evenodd"
                    ></path></svg
                  ></a>
              </div>
            </div>
          </section>
          <div class="my-6 pb-10 pt-6 lg:pb-16 lg:pt-14">
            <a
              id="link-start-shipping"
              class="inline-block rounded-md py-3 text-center font-semibold text-white shadow-sm transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent px-3.5 text-sm bg-accent hover:bg-orange-500 flex max-w-fit items-center gap-2 px-6 py-4 md:px-9 md:py-5 mx-auto"
              href="sign-up.html"
              title=""
              target="_self"
              data-sveltekit-reload
            ><span class="text-lg md:text-xl">Start Shipping</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="h-5 w-5"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                  clip-rule="evenodd"
                ></path></svg
              ></a>
          </div>
        </main>
      </div>
    </>
  );
};

export default Navbar;
