
import React from 'react';
import Header from '../customerHeader/Header';
import './Header.css'
//import './pagesStyle.css'


function AddressBook() {
  return (
    <>
    <Header />
    <h1>Address Book</h1>
    <div className="table-container">
      <table className="styled-table">
        <thead>
          <tr>
            <th>Address Type</th>
            <th>Address</th>
            <th>Date Created</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {/* Table rows */}
          <tr>
            <td>Recipient</td>
            <td>123 Main St</td>
            <td>2022-03-28</td>
            <td>
              <button>Edit</button>
              <button>Delete</button>
            </td>
          </tr>
          {/* more rows*/}
        </tbody>
     </table>
      {/* Table for address book */}
      {/* Search option */}
      {/* Add new option */}
      {/* Show option */}
      {/* Option to go to the second page */}
    </div>
    </>
  );
}

export default AddressBook;