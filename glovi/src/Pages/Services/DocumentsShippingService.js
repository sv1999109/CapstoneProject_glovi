import React from 'react';
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import DocumentsImg from '../../assets/Documents.png'
import './ServicesStyle.css'

function Documents() {
    return (
        <>
            <Header />
            <div className="Servicebody">
                <div className='Servicerow'>
                    <div className='Serviceimg'>
                        <img src={DocumentsImg} alt='Documents_Image'/>
                    </div>

                    <div className='Servicecontentwrapper'>
                        <div className='Servicecontent'>
                            <h2>Documents Delivery</h2>
                            <p>Simplify the global movement of your essential paperwork with our dedicated Documents Shipping Service.
                                Swift and secure, we handle documents weighing up to 2 kg, ensuring the safe delivery of your most
                                important items. From legal papers and contracts to certificates and sensitive materials, our service
                                guarantees the secure transport of your crucial documents.</p>

                            <h3>Service Highlights:</h3>
                            <ul>
                                <li><b>Maximum Weight:</b> Up to 2 kg</li>
                                <li><b>Examples of Items:</b> Legal documents,Contracts,Certificates,Business correspondence
                                    Personal ID Documents,Medical records</li>
                            </ul>

                            <p>Navigating through international document shipments has never been this efficient. With our streamlined
                                process and secure handling, you can trust us to ensure your documents reach their destination intact
                                and on time.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <Footer />

        </>
    );
}

export default Documents;
