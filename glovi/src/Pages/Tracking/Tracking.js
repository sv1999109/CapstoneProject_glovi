import {React,useEffect,useState} from 'react';
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import './TrackingStyle.css'


function Tracking() {
    const [heading, setHeading] = useState('');
    const headingText = "Track the Shipment";
    const delay = 400; 

    useEffect(() => {
        let index = 0;
        let timeoutId;

        const typeHeading = () => {
            if (index < headingText.length) {
                setHeading((prevHeading) => headingText.slice(0, index + 1));
                index++;
                timeoutId = setTimeout(typeHeading, delay);
            } else {
                clearTimeout(timeoutId);
                setHeading('');
                index = 0;
                timeoutId = setTimeout(typeHeading, delay); 
            }
        };

        timeoutId = setTimeout(typeHeading, delay);

        return () => clearTimeout(timeoutId);
    }, []);
    return (
        <>
            <Header />
            <div id="track-body">
            <h1 id='track-heading'>{heading}</h1>
                <div id='main-track-div'>
                    <h2>Tracking Number</h2><br></br>
                    <textarea placeholder='Enter up to 24 items, separated by commas or line breaks'  className="responsive-textarea"></textarea>
                </div>
                <button className='TrackButton'>Track</button>
            </div>

            <Footer />
        </>
    );
}

export default Tracking