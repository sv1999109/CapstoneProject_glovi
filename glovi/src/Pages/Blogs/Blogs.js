import React, { useState } from "react";
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import './BlogsStyle.css'
import PalletStacking from '../../assets/PalletStacking.jpg'
import MasterArt from '../../assets/MasterArt.jpg'
import Prohibited from '../../assets/Prohibited.jpg'
import { BiLinkExternal } from "react-icons/bi";

function Blogs() {
    const [popupActive, setPopupActive] = useState(false);
    const [popupContent, setPopupContent] = useState(null);

    function togglePopup(content) {
        setPopupContent(content);
        setPopupActive(!popupActive);
    }

    return (
        <>
            <Header />
            <div id="Blogsbody">
                <section id="blogsection">
                    <div className="blogheading">
                        <span>My Recent Posts</span>
                        <h3>My Blogs</h3>
                    </div>

                    <div className="blogcontainer">
                        {/* Blogbox1 */}
                        <div className="blogbox">
                            <div className="blogImg">
                                <img src={PalletStacking} alt="Pallet Stacking" />
                            </div>

                            <div className="blogtext">
                                <span>28 October 2023</span>
                                <p className="blogTitle" onClick={() => togglePopup(<PopupContent1 />)}>Pallet Stacking for Efficient Shipping with Glovi</p>
                                <p>Palletizing your shipments is an art that, when done right, can streamline your shipping process and maximize efficiency. Whether you're a business ow.. <a href="#!" className="learnMore" onClick={() => togglePopup(<PopupContent1 />)}>Learn More<BiLinkExternal className="arrow" /></a></p>
                            </div>
                        </div>
                        <div style={{ marginBottom: '20px' }}></div>
                        {/* Blogbox2 */}
                        <div className="blogbox">
                             <div style={{ marginBottom: '20px' }}></div>
                            <div className="blogtext">
                                <span>28 October 2023</span>
                                <p className="blogTitle" onClick={() => togglePopup(<PopupContent2 />)}>Mastering the Art of Packaging</p>
                                <p>Sending a package is more than just putting items in a box. The way you package your items plays a
                                    crucial role in ensuring they reach their destinati...<a href="#!" className="learnMore" onClick={() => togglePopup(<PopupContent2 />)}>Learn More<BiLinkExternal className="arrow" /></a></p>
                            </div>
                            <div className="blogImg">
                                <img src={MasterArt} alt="Mastering the Art of Packaging" />
                            </div>
                        </div>
                        <div style={{ marginBottom: '20px' }}></div>
                        {/* Blogbox3 */}
                        <div className="blogbox">
                            <div className="blogImg">
                                <img src={Prohibited} alt="Understanding Prohibited Items" />
                            </div>

                            <div className="blogtext">
                                <span>28 October 2023</span>
                                <p className="blogTitle" onClick={() => togglePopup(<PopupContent3 />)}>Understanding Prohibited Items</p>
                                <p>Palletizing your shipments is an art that, when done right, can streamline your shipping process
                                    and maximize efficiency. Whether you're a business ow..<a href="#!" className="learnMore" onClick={() => togglePopup(<PopupContent3 />)}>Learn More<BiLinkExternal className="arrow" /></a></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {popupActive && (
                <div className="Blogpopup" id="popup-1">
                    <div className="overlay" onClick={() => setPopupActive(false)}>
                        <div className="popContent">
                            <div className="close-btn">
                                &times;
                            </div>
                            {popupContent}
                        </div>
                    </div>
                </div>
            )}

            <Footer />
        </>
    )
}

// Define the content for each popup
const PopupContent1 = () => (

    <div className=" blog-container">
        <h1 className="Popup1-Heading">Pallet Stacking</h1>
        <div className="scrollable-content">
            <div className="blog-item" id="unique-blog-item-id">
                <p className="popupBlogParagaraph">Palletizing your shipments is an art that, when done right, can streamline your shipping process and maximize efficiency. Whether you're a business owner preparing a large shipment or an individual sending bulky items, understanding the principles of pallet stacking is key. In this guide, we'll explore the steps to master the art of pallet stacking for efficient shipping with Glovi.</p>

                <ol className="packaging-steps">
                    <li>
                        <strong>Choose the Right Pallet:</strong>
                        <p>Start by selecting a sturdy and appropriately sized pallet for your shipment. The pallet should comfortably accommodate the size and weight of your items without overhang.</p>
                    </li>
                    <li>
                        <strong>Organize Your Items:</strong>
                        <p>Categorize your items based on size, weight, and fragility. Grouping similar items together makes the stacking process more organized and helps distribute weight evenly across the pallet.</p>
                    </li>
                    <li>
                        <strong>Place Heavy Items at the Bottom:</strong>
                        <p>For stability and safety, position the heaviest items at the bottom of the pallet. This creates a solid foundation and prevents the pallet from becoming top-heavy, reducing the risk of items shifting during transit.</p>
                    </li>
                    <li>
                        <strong>Use Palletizing Accessories:</strong>
                        <p>Consider using palletizing accessories such as stretch wrap, pallet bands, or corner protectors. These accessories help secure the items on the pallet and provide additional stability during transportation.</p>
                    </li>
                    <li>
                        <strong>Wrap the Pallet Securely:</strong>
                        <p>Once the items are stacked, use stretch wrap or shrink wrap to secure the entire pallet. Start from the bottom and work your way up, ensuring each layer is tightly wrapped. This helps keep the items in place and protects them from dust, dirt, and potential damage.</p>
                    </li>
                    <li>
                        <strong>Consider Interlocking Boxes:</strong>
                        <p>If your shipment includes boxes, interlock them to create a stable structure. This prevents boxes from shifting and minimizes the risk of damage. Fill any gaps with smaller items or packaging materials to ensure a snug fit.</p>
                    </li>
                    <li>
                        <strong>Avoid Overhang:</strong>
                        <p>Ensure that items on the pallet do not overhang the edges. Overhanging items can be prone to damage during handling and transportation. Keep everything within the dimensions of the pallet.</p>
                    </li>
                    <li>
                        <strong>Label and Document:</strong>
                        <p> Clearly label the pallet with essential information, including the destination address, handling instructions, and any special considerations. Attach necessary documents, such as a packing list or shipping label, for easy identification.</p>
                    </li>
                    <li>
                        <strong>Stacking for Accessibility:</strong>
                        <p>If the pallet is part of a larger shipment, consider the accessibility of items. Stack items in a way that allows for easy retrieval when the pallet reaches its destination. This is particularly important for businesses with warehouses or distribution centers.</p>
                    </li>
                    <li>
                        <strong>Regularly Check Guidelines:</strong>
                        <p>Stay informed about the specific guidelines provided by Glovi for pallet shipments. Carrier guidelines may vary, and staying updated ensures that your pallets comply with Glovi's requirements.</p>
                    </li>
                </ol>

                <p className="blog-conclusion"> Conclusion: Mastering the art of pallet stacking is a valuable skill for optimizing your shipping process with Glovi. By choosing the right pallet, organizing items strategically, and securing the load properly, you contribute to a smoother and more efficient shipping experience.</p>

                <p className="blog-conclusion"> At Glovi, we value the care and precision you put into preparing your shipments. Make every pallet a testament to your commitment to safe and efficient shipping. Happy stacking!</p>

                <p><strong>Note:</strong> Always refer to Glovi's specific guidelines for pallet shipments and ensure compliance with their regulations.</p>
            </div>
        </div>
    </div >

);

const PopupContent2 = () => (
    
        <div className="blog-container">
            <h1 className="Popup1-Heading">Mastering the Art of Packaging</h1>
            <div className="scrollable-content">
                <div className="blog-item" id="unique-blog-item-id">
                    <p className="popupBlogParagaraph">
                        Sending a package is more than just putting items in a box. The way you package your items plays a crucial role in ensuring they reach their destination intact and in perfect condition. At Glovi, we understand the importance of proper packaging for a smooth and secure delivery experience. Let's dive into the art of packaging to make every Glovi shipment a success.
                    </p>
                    <ol className="packaging-steps">
                        <li><strong>Choose the Right Box:</strong>
                            <p>
                                The foundation of secure packaging is selecting the right box. Choose a sturdy, corrugated box that is appropriate for the size and weight of your items. Avoid using damaged or weak boxes, as they compromise the integrity of your shipment.
                            </p>
                        </li>
                        <li><strong>Wrap Fragile Items:</strong>
                            <p>
                                For fragile items, an extra layer of protection is essential. Wrap delicate items individually with bubble wrap or packing paper. Ensure that there's enough cushioning to absorb any impact during transit.
                            </p>
                        </li>
                        <li><strong>Secure with Cushioning:</strong>
                            <p>
                                Regardless of the contents, always add an ample amount of cushioning inside the box. Use packing peanuts, air pillows, or crumpled newspaper to fill any void spaces and provide extra protection against bumps and shocks.
                            </p>
                        </li>
                        <li><strong>Seal the Box Securely:</strong>
                            <p>
                                Use high-quality packing tape to seal the box securely. Reinforce the seams and edges of the box to prevent it from opening during transit. Make sure the tape is applied evenly and covers all seams.
                            </p>
                        </li>
                        <li><strong>Label Clearly:</strong>
                            <p>
                                Proper labeling is crucial for smooth transit and delivery. Clearly write the recipient's address, including postal codes and any specific delivery instructions. Place a duplicate label or include an additional label inside the box for redundancy.
                            </p>
                        </li>
                        <li><strong>Consider Custom Packaging:</strong>
                            <p>
                                For unique or irregularly shaped items, consider custom packaging. Design a box that perfectly fits your items, minimizing movement during transit. Custom packaging can enhance protection and create a professional presentation.
                            </p>
                        </li>
                        <li><strong>Document Your Shipment:</strong>
                            <p>
                                Include a packing slip or invoice inside the package. This serves as a record of the items shipped and helps in case of any issues during customs clearance. Clearly list the contents and their quantities.
                            </p>
                        </li>
                        <li><strong>Weather-Resistant Packaging:</strong>
                            <p>
                                If you're shipping to an area with unpredictable weather, consider weather-resistant packaging. Use plastic or waterproof wrapping to protect your items from rain or other environmental factors.
                            </p>
                        </li>
                        <li><strong>Follow Carrier Guidelines:</strong>
                            <p>
                                Different carriers may have specific guidelines for packaging. Familiarize yourself with the guidelines provided by Glovi or your chosen carrier. This ensures that your package meets the carrier's requirements.
                            </p>
                        </li>
                        <li><strong>Insure Valuable Items:</strong>
                            <p>
                                For valuable items, consider purchasing shipping insurance. While proper packaging minimizes the risk of damage, insurance provides an added layer of protection in case of unforeseen circumstances.
                            </p>
                        </li>
                    </ol>
                    <p className="blog-conclusion">
                        Conclusion: Mastering the art of packaging is a crucial step towards ensuring the safe and secure delivery of your items with Glovi. By following these guidelines, you not only protect your items but also contribute to a smoother shipping process. At Glovi, we're committed to delivering excellence in every shipment. Make your packaging a reflection of that commitment, and let's make each Glovi delivery an experience of reliability and care. Ship smart, ship safely, and let Glovi take your packages wherever they need to go!
                    </p>
                </div>
            </div>
        </div>
    
);

const PopupContent3 = () => (
   
        <div className="blog-container">
            <h1 className="Popup1-Heading">Understanding Prohibited Items</h1>
            <div className="scrollable-content">
                <div className="blog-item" id="unique-blog-item-id">
                    <p className="popupBlogParagaraph">
                        Shipping items across borders comes with its own set of rules and regulations. At Glovi, we prioritize the safety and compliance of our shipments. To ensure a smooth and secure shipping experience, it's crucial to be aware of prohibited items. Let's dive into a comprehensive guide to understand what items are restricted from shipping with Glovi.
                    </p>
                    <ol className="packaging-steps">
                        <li >
                            <strong>Why Are Some Items Prohibited?</strong>
                            <p>Before we delve into the specific items, let's understand why certain things are prohibited. Prohibitions are in place to ensure the safety of carriers, compliance with international laws, and to prevent harm to individuals and the environment. By adhering to these restrictions, we collectively contribute to a safer and more responsible shipping environment.</p>
                        </li>
                        <li>
                            <strong>Common Prohibited Items</strong>
                            <ol className="common-prohibited-items">
                                <li>
                                    <strong>a. Hazardous Materials:</strong>
                                    <p>Shipping hazardous materials is strictly prohibited. This includes items such as chemicals, explosives, and flammable substances. These pose a significant risk to transportation safety.</p>
                                </li>
                                <li>
                                    <strong>b. Perishable Goods:</strong>
                                    <p>Items that can spoil or decay during transit are prohibited. This includes perishable foods, plants, and live animals.</p>
                                </li>
                                <li>
                                    <strong>c. Illegal Substances:</strong>
                                    <p>It goes without saying that shipping illegal substances, including drugs and prohibited pharmaceuticals, is strictly forbidden.</p>
                                </li>
                                <li>
                                    <strong>d. Weapons and Firearms:</strong>
                                    <p>Shipping weapons, firearms, and ammunition is prohibited due to their potential for harm.</p>
                                </li>
                                <li>
                                    <strong>e. Counterfeit Items:</strong>
                                    <p>Items that infringe on intellectual property rights, such as counterfeit goods, are not allowed.</p>
                                </li>
                            </ol>
                        </li>
                        <li>
                            <strong>How to Ensure Compliance</strong>
                            <ol className="common-prohibited-items">
                                <li>
                                    <strong>a. Check Local Regulations:</strong>
                                    <p>Be aware of the regulations specific to the destination country. Some items may be legal in one country but restricted in another.</p>
                                </li>
                                <li>
                                    <strong>b. Consult Glovi's Guidelines:</strong>
                                    <p>Refer to Glovi's comprehensive guidelines on prohibited items. Our guidelines are designed to help you navigate through the shipping process with ease.</p>
                                </li>
                                <li>
                                    <strong>c. Package Properly:</strong>
                                    <p>Proper packaging is essential. Ensure that your items are securely packed to prevent damage during transit.</p>
                                </li>
                            </ol>
                        </li>
                        <li>
                            <strong>Why Compliance Matters</strong>
                            <p>Shipping prohibited items not only puts the safety of carriers at risk but can also result in legal consequences. Compliance ensures that your shipments arrive safely and that you remain within the bounds of the law.</p>
                        </li>
                    </ol>

                    <p className="blog-conclusion">
                        Conclusion: Shipping with Glovi is not just about getting your items from point A to point B; it's about doing so responsibly. By understanding and adhering to prohibited item guidelines, you play a crucial role in creating a secure and efficient shipping environment for everyone. Stay informed, ship responsibly, and let's make every Glovi shipment a safe and successful one!</p>


                </div>
            </div>
        </div>
 
);

export default Blogs;
