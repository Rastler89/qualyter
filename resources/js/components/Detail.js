
import React, { useState, useEffect} from "react";
import i18n from "../helpers/i18n";
import Answer from "./Answer";

export default function Detail(props)  {
    const info = props.object;
console.log(info);
    let stars = [];
    let buttons = [];

    const [viewAnswer, setView] = useState(0);

    for(let i=1; i<=info.client.average; i++) {
        stars.push(<img key={i} src="/img/star-hover.svg" width="60" height="60" />);
    }
    if(info.client.average%1 > 0.5) {
        stars.push(<img key={'medians'} src="/img/star-hover-half.svg" width="60" height="60" />)
    }
    
    let list = [
        {
            label: i18n.t('other.period'), 
            content: info.extra['visits']+' '+i18n.t('other.visits')
        },
        {
            label: i18n.t('other.telephone'), 
            content: info.extra['qc']+' '+i18n.t('other.call')
        },
        {
            label: i18n.t('other.email'), 
            content: info.extra['send']+' '+i18n.t('other.surveys_sended')
        },
        {
            label: i18n.t('other.responses'), 
            content: info.extra['resp']+' '+i18n.t('other.surveys_respond')
        },
        {
            label: i18n.t('other.contacted'), 
            content: info.extra['per_con']+'%'
        },
        {
            label: i18n.t('other.rate'), 
            content: info.extra['per_ans']+'%'
        },
        {
            label: i18n.t('other.total'), 
            content: info.extra['tot_ans']+'%'
        },
    ];

    if(viewAnswer>0) {
        buttons.push(<button type="button" onClick={prev} id="previous" className={'btn btn-outline-primary'}>{i18n.t('other.previous')}</button>);
    } else {
        buttons.push(<button type="button" onClick={prev} id="previous" className={'btn btn-outline-primary'} disabled>{i18n.t('other.previous')}</button>)
    }
    if(viewAnswer<info.answers.length-1) {
        buttons.push(<button type="button" onClick={next} id="next" className={'btn btn-outline-primary'}>{i18n.t('other.next')}</button>)
    } else {
        buttons.push(<button type="button" onClick={next} id="next" className={'btn btn-outline-primary'} disabled>{i18n.t('other.next')}</button>)
    }

    function prev() {
        setView(viewAnswer-1)
    }

    function next() {
        setView(viewAnswer+1)
    }
    let total = info.answers.length;

    return (
        <section>
            <h1 className={'text-center mb-3'}>{info.client.name}</h1>
            <div className={'row'}>
                <div className={'col-md-4'}>
                    <h5 className={'mb-4'}>{i18n.t('other.reporting')}: {info.first_day} - {info.last_day}</h5>
                    <h2 className={'text-center mt-3'}>{info.client.average}</h2>
                    <p className={'text-center'}>
                        {stars}
                    </p>
                    <ul>
                        {list.map((element,index) => {
                            return <li key={index} className={'list-group-item'}>{element.label}: <strong>{element.content}</strong></li>
                        })}
                        <li class="list-group-item"><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#notRespond">{i18n.t('other.unanswered')}</button></li>
                    </ul>

                    <ul>
                        <li class="list-group-item text-danger">{i18n.t('other.open_inc')}: {info.extra['per_inc']} %</li>
                        <li class="list-group-item text-warning">{i18n.t('other.inc_close')}: {info.extra['per_inc_close']}%</li>
                        <li class="list-group-item text-warning">{i18n.t('other.timing')}: {info.extra['timing']}</li>
                        <li class="list-group-item text-success">{i18n.t('other.congratulations')}: {info.extra['per_cong']}%</li>
                    </ul>
                </div>
                {info.answers.length==0 ?
                    <div className={'col-md-8'}>
                        <h3>Elements not found</h3>
                    </div>
                 : 
                    <div className={'col-md-8'}>
                        <div id="counter" className={'text-center mb-3'}>
                            {i18n.t('other.answers')}: {viewAnswer+1} - {total}
                        </div>
                        <div className={'btn-group col-12 mb-1'} role="group" aria-label="navigation" id="navigation">
                            {buttons}
                        </div>
                        <Answer answer={info.answers[viewAnswer]} />
                    </div>
                 }
            </div>
            <div class="modal fade" id="notRespond" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="notRespondLabel" aria-hidden="true">
            <div className={'modal-dialog modal-xl'}>
                <div className={'modal-content'}>
                    <div className={'modal-header'}>
                        <h5 className={'modal-title'} id="notRespondLabel">{i18n.t('other.shop_unanswered')}</h5>
                        <button type="button" className={'btn-close'} data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div className={'modal-body'}>
                        <table className={'table table-striped table-hover'}>
                            <thead>
                                <tr>
                                    <td>{i18n.t('other.code')}</td>
                                    <td>{i18n.t('other.name')}</td>
                                    <td>{i18n.t('other.not_respond')}</td>
                                </tr>
                            </thead>
                            <tbody>
                                {info.notResponds.map((notRespond) => {
                                    return (
                                        <tr>
                                            <td>{notRespond.code}</td>
                                            <td>{notRespond.name}</td>
                                            <td>{notRespond.total}</td>
                                        </tr>

                                    )
                                })}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </section>
    )
}