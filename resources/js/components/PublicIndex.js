// resources/js/components/HelloReact.js

import React, { useState, useEffect} from 'react';
import { createRoot } from 'react-dom/client';
import Detail from './Detail';
import Delegation from './Delegation';
import i18n from "../helpers/i18n";

import { Dna } from  'react-loader-spinner'

const getInfo = (url,m,y) => {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({month: m, year: y})
    })
    .then(res => res.json())
    .then(response => {
        const data = response;
        return data;
    });
}

export const PublicIndex= () => {
    const [month, setMonth] = useState(new Date().getMonth());
    const [year, setYear] = useState(new Date().getFullYear());
    const [info, setInfo] = useState([]);
    const [loading, setLoading] = useState(false);
    
    let father = '';
    var URLactual = window.location.pathname;
    let array = URLactual.split('/');
    var url;
    if(array.length==3) {
        url = '/api/public/'+array[2];
    } else if(array.length==5) {
        url = '/api/public/'+array[2]+'/detail/'+array[4];
        father = <a className={'btn btn-outline-primary'} href={'/public/'+array[2]}><img width="30px" height="30px" src="/img/preview.svg" /></a>;
    }

    function change(e,type) {
        if(type=='m') {
            setMonth(e.target.value);
            getInfo(url,e.target.value,year).then(data => {
                setInfo(data);
            });
        } else {
            setYear(e.target.value);
            getInfo(url,month,e.target.value).then(data => {
                setInfo(data);
            });
        }
        
    }

    var months = [
        { value: 0, label: i18n.t('month.December')},
        { value: 1, label: i18n.t('month.January')},
        { value: 2, label: i18n.t('month.February')},
        { value: 3, label: i18n.t('month.March')},
        { value: 4, label: i18n.t('month.April')},
        { value: 5, label: i18n.t('month.May')},
        { value: 6, label: i18n.t('month.June')},
        { value: 7, label: i18n.t('month.July')},
        { value: 8, label: i18n.t('month.August')},
        { value: 9, label: i18n.t('month.September')},
        { value: 10, label: i18n.t('month.October')},
        { value: 11, label: i18n.t('month.November')}
    ];

    var years = [];

    for(let i=2022;i<=year;i++) {
        years.push({value: i, label: i});
    }

    var select = 
        <div className={'row mb-4'}>
            <div className={'col'}>
                <select className={'form-select'} value={month} onChange={event => change(event,'m')}>
                    {months.map((mon) => (
                        <option value={mon.value} >{mon.label}</option>
                    ))}
                </select>
            </div>
            <div className={'col'}>
                <select className={'form-select'} value={year} onChange={event => change(event,'y')}>
                    {years.map((y) => (
                        <option value={y.value}>{y.label}</option>
                    ))}
                </select>
            </div>
        </div>;
    

    useEffect(() => {
        getInfo(url,month,year).then(data => {
            setInfo(data);
            setLoading(true);
        });
        
    }, []);


    if(!loading) {
        return (
            <div
      style={{
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        height: '40vh',
      }}
    >
        <Dna
            visible={true}
            height="200"
            width="200"
            ariaLabel="dna-loading"
            wrapperStyle={{}}
            wrapperClass="dna-wrapper"
        />

    </div>
            )
    } else {
        if(info.type=='delegation') {
            let delegations = info.delegations;
            let size;

            switch(delegations.length) {
                case 0:
                case 1: size = 12; break;
                case 2: size = 6; break;
                case 3: size = 4; break;
                case 4:
                default: size = 3; break;
            }

            return (
                <section>
                    {select}
                    <h3 className={'text-center mb-3'}>{i18n.t('month.label')}</h3>
                    <div className={'row'}>
                        {delegations.map((delegation) => 
                            <Delegation object={delegation} size={size}  />
                        )}
                    </div>
                </section>
            )
        } else {
            return (
                <section>
                    {select}
                    {father}
                    <Detail object={info}/>
                </section>
            )
        }
    }
}

const container = document.getElementById('public-index');
const root = createRoot(container);
root.render(<PublicIndex />)