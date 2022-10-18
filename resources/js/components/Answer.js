import React from "react";
import i18n from "../helpers/i18n";
import WorkOrder from "./WorkOrder";
import BodyAnswer from "./bodyAnswer";

export default function Answer(props)  {
    const answer = props.answer;
    let ots = [];

    let respuesta = JSON.parse(answer['answer']);

    let stars = [];

    for(let e=0; e<4; e++) {
        stars[e] = [];
        for(let i=1; i<=respuesta['valoration'][e]; i++) {
            stars[e].push(<img key={i} src="/img/star-hover.svg" width="50" height="50" />);
        }
        if(respuesta['valoration'][e]%1 > 0.5) {
            stars[e].push(<img key={'medians'} src="/img/star-hover-half.svg" width="50" height="50" />)
        }
    }
    return (
        <div className={'col-12'}>
            <div className={'card text-center'}>
                <div className={'card-body'}>
                    <strong>{answer['shop']}</strong><br />
                    {answer['updated_at']}<br />
                    {answer['workOrders'].map(ot => {
                        return <WorkOrder key={ot.code} work={ot} />
                    })}
                </div>
            </div>
            <div className={'accordion'} id="accordionPanelsStayOpenExample">
                <div className={'accordion-item'}>
                    <h2 className={'accordion-header'} id="panelsStayOpen-headingOne">
                        <button className={'accordion-button'} type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            {i18n.t('answer.first')}
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" className={'accordion-collapse collapse show'} aria-labelledby="panelsStayOpen-headingOne">
                        <BodyAnswer stars={stars[0]} valoration={respuesta['valoration'][0]} comment={respuesta['comment'][0]} />
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            {i18n.t('answer.second')}
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <BodyAnswer stars={stars[1]} valoration={respuesta['valoration'][1]} comment={respuesta['comment'][1]} />
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                            {i18n.t('answer.third')}
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <BodyAnswer stars={stars[2]} valoration={respuesta['valoration'][2]} comment={respuesta['comment'][2]} />
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-control="panelsStayOpen-collapseFour">
                            {i18n.t('answer.fourth')}
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                        <BodyAnswer stars={stars[3]} valoration={respuesta['valoration'][3]} comment={respuesta['comment'][3]} />
                    </div>
                </div>
            </div>
        </div>
    )
}