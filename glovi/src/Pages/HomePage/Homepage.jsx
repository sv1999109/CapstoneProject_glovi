import React from 'react';
import Header from '../../Components/Header/Header.js';
import Hero from './HomepageItems/Hero.jsx';
import Features from './HomepageItems/Features.jsx';
import Numbers from './HomepageItems/Numbers.jsx';
import Footer from '../../Components/Footer/Footer.js';
import Testimonials from './HomepageItems/Testimonials.jsx';
export default function Homepage() {
    return (
        <>
            <Header />
            <Hero />
            <Numbers />
            <Features />
            <Testimonials />
            <Footer />
        </>
    )
}