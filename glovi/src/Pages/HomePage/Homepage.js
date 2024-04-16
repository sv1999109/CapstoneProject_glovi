import React from 'react';
import Header from '../../Components/Header/Header.js';
import Features from './HomepageItems/Features.js';
import Numbers from './HomepageItems/Numbers.js';
import Footer from '../../Components/Footer/Footer.js';
import Testimonials from './HomepageItems/Testimonials.js';
import HeroSection from './HeroSection/HeroSection.js';
export default function Homepage() {
    return (
        <>
            <Header />
            <HeroSection />
            <Numbers />
            <Features />
            <Testimonials />
            <Footer />
        </>
    )
}